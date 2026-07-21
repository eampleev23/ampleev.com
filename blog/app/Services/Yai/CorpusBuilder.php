<?php

namespace App\Services\Yai;

use DOMDocument;
use DOMXPath;

/**
 * Собирает базу знаний «ЯAI» из тех же source-файлов, что и публикация статей:
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

        foreach ($this->collectDraftDocs(storage_path('drafts'), 'ru') as $doc) {
            $docs[] = $doc;
        }
        foreach ($this->collectDraftDocs(storage_path('drafts/en'), 'en') as $doc) {
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
            ];

            foreach ($this->chunker->split($doc['text']) as $seq => $chunkText) {
                $tokens = $this->normalizer->tokenize($doc['title'] . "\n" . $chunkText);
                $tf = array_count_values($tokens);
                $chunks[] = [
                    'id' => $chunkId++,
                    'doc' => $doc['id'],
                    'seq' => $seq,
                    'text' => $chunkText,
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
        file_put_contents($path, json_encode($corpus, JSON_UNESCAPED_UNICODE));

        return $corpus['stats'];
    }

    private function collectDraftDocs(string $dir, string $lang): array
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

            $urlPrefix = $lang === 'en' ? '/en/article_' : '/article_';
            $docs[] = [
                'id' => $lang . ':' . $slug,
                'lang' => $lang,
                'title' => $parsed['title'] ?: $slug,
                'url' => 'https://ampleev.com' . $urlPrefix . $slug,
                'type' => 'article',
                'text' => $parsed['text'],
            ];
        }

        return $docs;
    }

    /**
     * @return array{title: string, text: string}|null
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

        return ['title' => $title, 'text' => $text];
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
                'text' => $text,
            ];
        }

        return $docs;
    }
}
