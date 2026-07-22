<?php

namespace App\Services\Yai;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\DB;

/**
 * Собирает базу знаний «AIЯ» из тех же source-файлов, что и публикация статей:
 * storage/drafts/*.html (RU), storage/drafts/en/*.html (EN) и research-брифов
 * storage/research/*.md. Не зависит от БД — корпус можно пересобрать где угодно
 * командой `php artisan yai:build-corpus`.
 */
class CorpusBuilder
{
    private TextNormalizer $normalizer;
    private Chunker $chunker;

    public function __construct()
    {
        $this->normalizer = new TextNormalizer();
        $this->chunker = new Chunker();
    }

    /**
     * @return array{docs: array, chunks: array, stats: array}
     */
    public function build(): array
    {
        $docs = [];
        $chunks = [];

        [$publishedRu, $publishedEn] = $this->loadPublishedSlugs();

        foreach ($this->collectDraftDocs(storage_path('drafts'), 'ru', $publishedRu) as $doc) {
            $docs[] = $doc;
        }
        foreach ($this->collectDraftDocs(storage_path('drafts/en'), 'en', $publishedEn) as $doc) {
            $docs[] = $doc;
        }
        if (config('yai.include_research')) {
            foreach ($this->collectResearchDocs(storage_path('research')) as $doc) {
                $docs[] = $doc;
            }
        }

        $docMeta = [];
        $chunkId = 0;
        foreach ($docs as $doc) {
            $docMeta[] = [
                'id' => $doc['id'],
                'lang' => $doc['lang'],
                'title' => $doc['title'],
                'url' => $doc['url'],
                'type' => $doc['type'],
                'date' => $doc['date'] ?? null,
            ];

            foreach ($this->chunker->split($doc['text']) as $seq => $chunkText) {
                $tokens = $this->normalizer->tokenize($doc['title'] . "\n" . $chunkText);
                $tf = array_count_values($tokens);
                $chunks[] = [
                    'id' => $chunkId++,
                    'doc' => $doc['id'],
                    'seq' => $seq,
                    'text' => $chunkText,
                    // Хэш содержимого — ключ кэша эмбеддингов между пересборками
                    'hash' => md5($doc['title'] . "\n" . $chunkText),
                    'tf' => $tf,
                    'len' => count($tokens),
                ];
            }
        }

        // Глобальная статистика для BM25: document frequency и средняя длина чанка
        $df = [];
        $totalLen = 0;
        foreach ($chunks as $chunk) {
            $totalLen += $chunk['len'];
            foreach (array_keys($chunk['tf']) as $term) {
                $df[$term] = ($df[$term] ?? 0) + 1;
            }
        }

        return [
            'docs' => $docMeta,
            'chunks' => $chunks,
            'stats' => [
                'built_at' => now()->toIso8601String(),
                'doc_count' => count($docMeta),
                'chunk_count' => count($chunks),
                'avgdl' => count($chunks) > 0 ? $totalLen / count($chunks) : 0,
                'df' => $df,
            ],
        ];
    }

    public function buildAndSave(): array
    {
        $corpus = $this->build();

        $path = config('yai.corpus_path');
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0775, true);
        }

        // Векторы строятся ДО перезаписи corpus.json — кэш эмбеддингов читается
        // из предыдущей версии корпуса
        $corpus['stats']['vectors'] = $this->buildVectors($corpus);

        // Атомарная запись (tmp + rename): живые запросы не должны увидеть
        // недописанный JSON; отпечаток file_md5 в stats связывает corpus.json
        // с конкретной версией vectors.bin
        $this->atomicWrite($path, json_encode($corpus, JSON_UNESCAPED_UNICODE));

        return $corpus['stats'];
    }

    private function atomicWrite(string $path, string $contents): void
    {
        $tmp = $path . '.tmp.' . getmypid();
        file_put_contents($tmp, $contents);
        rename($tmp, $path);
    }

    /**
     * Эмбеддинги чанков для гибридного поиска: неизменившиеся чанки берутся из
     * кэша (по хэшу содержимого), новые — считаются батчами. При недоступности
     * эмбеддингов гибрид отключается, BM25 продолжает работать.
     */
    private function buildVectors(array $corpus): array
    {
        $client = new OpenRouterClient();
        $vectorsPath = config('yai.vectors_path');
        $dims = (int) config('yai.embeddings.dimensions', 512);

        if (!$client->embeddingsConfigured()) {
            @unlink($vectorsPath);
            return ['enabled' => false, 'reason' => 'embeddings api key is not set'];
        }

        $cache = $this->loadPreviousVectors($dims);

        $titles = [];
        foreach ($corpus['docs'] as $doc) {
            $titles[$doc['id']] = $doc['title'];
        }

        $vectors = [];
        $toEmbed = [];
        foreach ($corpus['chunks'] as $i => $chunk) {
            if (isset($cache[$chunk['hash']])) {
                $vectors[$i] = $cache[$chunk['hash']];
            } else {
                $toEmbed[$i] = mb_substr(($titles[$chunk['doc']] ?? '') . "\n" . $chunk['text'], 0, 6000);
            }
        }

        foreach (array_chunk($toEmbed, 96, true) as $batch) {
            $embedded = $client->embed(array_values($batch));
            if ($embedded === null) {
                @unlink($vectorsPath);
                return ['enabled' => false, 'reason' => 'embedding call failed'];
            }
            foreach (array_keys($batch) as $j => $chunkIndex) {
                $vectors[$chunkIndex] = $embedded[$j];
            }
        }

        ksort($vectors);
        $bin = '';
        foreach ($vectors as $vector) {
            $bin .= pack('g*', ...$vector);
        }
        $this->atomicWrite($vectorsPath, $bin);

        return [
            'enabled' => true,
            'dims' => $dims,
            'file_md5' => md5($bin),
            'reused' => count($corpus['chunks']) - count($toEmbed),
            'embedded' => count($toEmbed),
        ];
    }

    /**
     * Кэш «хэш чанка → вектор» из предыдущей пары corpus.json + vectors.bin.
     *
     * @return array<string, float[]>
     */
    private function loadPreviousVectors(int $dims): array
    {
        $corpusPath = config('yai.corpus_path');
        $vectorsPath = config('yai.vectors_path');
        if (!is_file($corpusPath) || !is_file($vectorsPath)) {
            return [];
        }

        $old = json_decode((string) file_get_contents($corpusPath), true);
        if (!is_array($old) || (int) ($old['stats']['vectors']['dims'] ?? 0) !== $dims) {
            return [];
        }

        $chunks = $old['chunks'] ?? [];
        $bin = (string) file_get_contents($vectorsPath);
        if (strlen($bin) !== count($chunks) * $dims * 4) {
            return [];
        }

        $cache = [];
        foreach ($chunks as $i => $chunk) {
            if (isset($chunk['hash'])) {
                $cache[$chunk['hash']] = array_values(unpack('g' . $dims, substr($bin, $i * $dims * 4, $dims * 4)));
            }
        }

        return $cache;
    }

    /**
     * Карты «слаг опубликованной статьи → дата создания» (RU и EN). null — БД
     * недоступна, тогда публикацию не проверяем (мягкая деградация).
     *
     * @return array{0: array<string, string>|null, 1: array<string, string>|null}
     */
    private function loadPublishedSlugs(): array
    {
        try {
            $ru = DB::table('articles')
                ->where('confirmed', 1)
                ->pluck('created_at', 'text_url')
                ->map(fn ($d) => (string) $d)
                ->all();
            $en = DB::table('article_translations')
                ->join('articles', 'articles.id', '=', 'article_translations.article_id')
                ->where('article_translations.locale', 'en')
                ->where('articles.confirmed', 1)
                ->pluck('articles.created_at', 'article_translations.text_url')
                ->map(fn ($d) => (string) $d)
                ->all();

            return [$ru, $en];
        } catch (\Throwable $e) {
            return [null, null];
        }
    }

    private function collectDraftDocs(string $dir, string $lang, ?array $publishedSlugs): array
    {
        if (!is_dir($dir)) {
            return [];
        }

        $excluded = config('yai.exclude_drafts', []);
        $docs = [];

        foreach (glob($dir . '/*.html') as $file) {
            $slug = basename($file, '.html');
            if (in_array($slug, $excluded, true) || str_contains($slug, '(draft)')) {
                continue;
            }

            $parsed = $this->parseDraftHtml((string) file_get_contents($file));
            if ($parsed === null || mb_strlen($parsed['text']) < 400) {
                continue;
            }

            // Неопубликованный драфт остаётся в базе знаний, но без URL:
            // ссылка на несуществующую страницу хуже, чем её отсутствие
            $isPublished = $publishedSlugs === null || isset($publishedSlugs[$slug]);
            $urlPrefix = $lang === 'en' ? '/en/article_' : '/article_';
            // Дата нужна модели, чтобы не выдавать статусы из старых текстов за
            // текущие. У опубликованных — из БД; у драфтов — только из meta-тега
            // article-date (mtime не годится: git reset на сервере его перезаписывает).
            $date = isset($publishedSlugs[$slug])
                ? substr($publishedSlugs[$slug], 0, 7)
                : $parsed['date'];
            $docs[] = [
                'id' => $lang . ':' . $slug,
                'lang' => $lang,
                'title' => $parsed['title'] ?: $slug,
                'url' => $isPublished ? 'https://ampleev.com' . $urlPrefix . $slug : null,
                'type' => 'article',
                'date' => $date,
                'text' => $parsed['text'],
            ];
        }

        return $docs;
    }

    /**
     * @return array{title: string, text: string, date: string|null}|null
     */
    private function parseDraftHtml(string $html): ?array
    {
        if (trim($html) === '') {
            return null;
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $loaded = $dom->loadHTML('<?xml encoding="utf-8"?>' . $html);
        libxml_clear_errors();
        if (!$loaded) {
            return null;
        }

        $xpath = new DOMXPath($dom);

        $title = '';
        $titleNode = $xpath->query('//meta[@name="article-title"]/@content');
        if ($titleNode->length > 0) {
            $title = trim($titleNode->item(0)->nodeValue);
        }

        // Опциональный meta-тег с датой написания драфта (YYYY-MM или YYYY-MM-DD)
        $date = null;
        $dateNode = $xpath->query('//meta[@name="article-date"]/@content');
        if ($dateNode->length > 0 && preg_match('/^\d{4}-\d{2}/', trim($dateNode->item(0)->nodeValue), $m)) {
            $date = $m[0];
        }

        // Убираем script/style/blockquote-дубли не нужно — берём текст контентных блоков
        foreach ($xpath->query('//script | //style') as $node) {
            $node->parentNode->removeChild($node);
        }

        $textParts = [];
        foreach ($xpath->query('//div[contains(@class,"first-paragraph")] | //div[contains(@class,"content")]') as $node) {
            $textParts[] = $this->domTextWithParagraphs($node, $xpath);
        }
        if ($textParts === []) {
            $body = $xpath->query('//body')->item(0);
            if ($body !== null) {
                $textParts[] = $this->domTextWithParagraphs($body, $xpath);
            }
        }

        $text = trim(implode("\n\n", $textParts));
        $text = preg_replace("/[ \t]+/u", ' ', $text);
        $text = preg_replace("/\n{3,}/u", "\n\n", $text);

        return ['title' => $title, 'text' => $text, 'date' => $date];
    }

    private function domTextWithParagraphs(\DOMNode $root, DOMXPath $xpath): string
    {
        $parts = [];
        foreach ($xpath->query('.//p | .//h2 | .//h3 | .//h4 | .//li | .//blockquote', $root) as $node) {
            // li внутри уже собранного blockquote/p не дублируем
            if ($node->parentNode !== null && in_array($node->parentNode->nodeName, ['blockquote'], true)) {
                continue;
            }
            $value = trim(preg_replace('/\s+/u', ' ', $node->textContent));
            if ($value !== '') {
                $parts[] = $value;
            }
        }

        if ($parts === []) {
            return trim(preg_replace('/\s+/u', ' ', $root->textContent));
        }

        return implode("\n\n", array_unique($parts));
    }

    private function collectResearchDocs(string $dir): array
    {
        if (!is_dir($dir)) {
            return [];
        }

        $docs = [];
        foreach (glob($dir . '/*.md') as $file) {
            $slug = basename($file, '.md');
            // Visual-брифы — служебные ТЗ на картинки, в базу знаний не идут
            if (str_contains($slug, 'visual_brief')) {
                continue;
            }

            $raw = (string) file_get_contents($file);
            if (mb_strlen($raw) < 400) {
                continue;
            }

            $title = $slug;
            if (preg_match('/^#\s+(.+)$/mu', $raw, $m)) {
                $title = trim($m[1]);
            }

            // Markdown → плоский текст: убираем разметку, оставляем содержимое
            $text = preg_replace('/^#{1,6}\s+/mu', '', $raw);
            $text = preg_replace('/\[([^\]]*)\]\([^)]*\)/u', '$1', $text);
            $text = preg_replace('/[*_`>|-]{1,}/u', ' ', $text);
            $text = preg_replace("/[ \t]+/u", ' ', $text);
            $text = trim(preg_replace("/\n{3,}/u", "\n\n", $text));

            $docs[] = [
                'id' => 'research:' . $slug,
                'lang' => 'ru',
                'title' => $title,
                'url' => null,
                'type' => 'research',
                // mtime не годится как дата написания (git reset его перезаписывает)
                'date' => null,
                'text' => $text,
            ];
        }

        return $docs;
    }
}
