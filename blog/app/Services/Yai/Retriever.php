<?php

namespace App\Services\Yai;

/**
 * Гибридный поиск релевантных чанков: BM25 (k1=1.5, b=0.75) + косинусная
 * близость эмбеддингов, слияние ранжирований через Reciprocal Rank Fusion.
 * Если векторы недоступны (нет ключа/файла) — работает чистый BM25.
 * Буст чанков на языке вопроса и ограничение «не более N чанков на документ».
 */
class Retriever
{
    private const K1 = 1.5;
    private const B = 0.75;

    private TextNormalizer $normalizer;
    private OpenRouterClient $client;

    /** @var array|null кэш корпуса на время запроса */
    private ?array $corpus = null;

    public function __construct()
    {
        $this->normalizer = new TextNormalizer();
        $this->client = new OpenRouterClient();
    }

    public function corpusReady(): bool
    {
        return is_file(config('yai.corpus_path'));
    }

    /**
     * @return array<int, array{text: string, score: float, doc: array}>
     */
    public function search(string $query, ?int $topK = null, bool $bm25Only = false, ?string $lang = null): array
    {
        $corpus = $this->loadCorpus();
        if ($corpus === null) {
            return [];
        }

        // Язык буста задаётся исходным сообщением посетителя ($lang): переформулировка
        // может подмешать русские термины в англоязычный запрос
        $queryLang = $lang ?? ($this->normalizer->isCyrillic($query) ? 'ru' : 'en');
        $topK = $topK ?? (int) config('yai.retrieval.top_k', 6);
        $maxPerDoc = (int) config('yai.retrieval.max_per_doc', 2);
        $langBoost = (float) config('yai.retrieval.same_lang_boost', 1.2);

        $bm25Ranking = $this->bm25Ranking($corpus, $query);

        $vectorRanking = $bm25Only ? [] : $this->vectorRanking($corpus, $query);
        $merged = $vectorRanking === []
            ? $bm25Ranking
            : $this->fuseRankings($bm25Ranking, $vectorRanking);

        if ($merged === []) {
            return [];
        }

        $docsById = [];
        foreach ($corpus['docs'] as $doc) {
            $docsById[$doc['id']] = $doc;
        }

        // Языковой буст применяем к итоговому скору слияния
        $scored = [];
        foreach ($merged as $chunkIndex => $score) {
            $chunk = $corpus['chunks'][$chunkIndex];
            $doc = $docsById[$chunk['doc']] ?? null;
            if ($doc === null) {
                continue;
            }
            if ($doc['lang'] === $queryLang) {
                $score *= $langBoost;
            }
            $scored[] = ['text' => $chunk['text'], 'score' => $score, 'doc' => $doc];
        }

        usort($scored, fn ($a, $b) => $b['score'] <=> $a['score']);

        $result = [];
        $perDoc = [];
        foreach ($scored as $item) {
            $docId = $item['doc']['id'];
            if (($perDoc[$docId] ?? 0) >= $maxPerDoc) {
                continue;
            }
            $perDoc[$docId] = ($perDoc[$docId] ?? 0) + 1;
            $result[] = $item;
            if (count($result) >= $topK) {
                break;
            }
        }

        return $result;
    }

    /**
     * @return array<int, float> индекс чанка => BM25-скор (только положительные)
     */
    private function bm25Ranking(array $corpus, string $query): array
    {
        $queryTokens = array_unique($this->normalizer->tokenize($query));
        if ($queryTokens === []) {
            return [];
        }

        $df = $corpus['stats']['df'];
        $avgdl = max($corpus['stats']['avgdl'], 1);
        $n = count($corpus['chunks']);

        $scores = [];
        foreach ($corpus['chunks'] as $i => $chunk) {
            $score = 0.0;
            foreach ($queryTokens as $term) {
                $tf = $chunk['tf'][$term] ?? 0;
                if ($tf === 0) {
                    continue;
                }
                $termDf = $df[$term] ?? 0;
                $idf = log(1 + ($n - $termDf + 0.5) / ($termDf + 0.5));
                $score += $idf * ($tf * (self::K1 + 1))
                    / ($tf + self::K1 * (1 - self::B + self::B * $chunk['len'] / $avgdl));
            }
            if ($score > 0) {
                $scores[$i] = $score;
            }
        }

        arsort($scores);

        return $scores;
    }

    /**
     * @return array<int, float> индекс чанка => косинусная близость (топ-30)
     */
    private function vectorRanking(array $corpus, string $query): array
    {
        $vectorInfo = $corpus['stats']['vectors'] ?? null;
        if (!is_array($vectorInfo) || !($vectorInfo['enabled'] ?? false)) {
            return [];
        }

        $dims = (int) $vectorInfo['dims'];
        $vectorsPath = config('yai.vectors_path');
        if (!is_file($vectorsPath)) {
            return [];
        }
        $bin = (string) file_get_contents($vectorsPath);
        if (strlen($bin) !== count($corpus['chunks']) * $dims * 4) {
            return [];
        }
        // Отпечаток гарантирует, что vectors.bin — ровно та версия, под которую
        // собран corpus.json (защита от рассинхрона при прерванной пересборке)
        if (isset($vectorInfo['file_md5']) && md5($bin) !== $vectorInfo['file_md5']) {
            return [];
        }

        $embedded = $this->client->embed([mb_substr($query, 0, 2000)]);
        if ($embedded === null || !isset($embedded[0])) {
            return [];
        }
        $queryVector = $embedded[0];

        // Эмбеддинги OpenAI нормированы — косинус равен скалярному произведению
        $scores = [];
        foreach ($corpus['chunks'] as $i => $chunk) {
            $vector = unpack('g' . $dims, substr($bin, $i * $dims * 4, $dims * 4));
            $dot = 0.0;
            $k = 1;
            foreach ($queryVector as $value) {
                $dot += $value * $vector[$k++];
            }
            $scores[$i] = $dot;
        }

        arsort($scores);

        return array_slice($scores, 0, 30, true);
    }

    /**
     * Reciprocal Rank Fusion: score = Σ 1/(rrf_k + rank) по обоим ранжированиям.
     *
     * @param array<int, float> $bm25 отсортированное ранжирование BM25
     * @param array<int, float> $vector отсортированное векторное ранжирование
     * @return array<int, float> индекс чанка => RRF-скор
     */
    private function fuseRankings(array $bm25, array $vector): array
    {
        $rrfK = (int) config('yai.retrieval.rrf_k', 60);
        $fused = [];

        $rank = 0;
        foreach (array_keys($bm25) as $chunkIndex) {
            $fused[$chunkIndex] = ($fused[$chunkIndex] ?? 0) + 1 / ($rrfK + ++$rank);
        }
        $rank = 0;
        foreach (array_keys($vector) as $chunkIndex) {
            $fused[$chunkIndex] = ($fused[$chunkIndex] ?? 0) + 1 / ($rrfK + ++$rank);
        }

        arsort($fused);

        return $fused;
    }

    private function loadCorpus(): ?array
    {
        if ($this->corpus !== null) {
            return $this->corpus;
        }

        $path = config('yai.corpus_path');
        if (!is_file($path)) {
            return null;
        }

        $decoded = json_decode((string) file_get_contents($path), true);
        if (!is_array($decoded) || !isset($decoded['chunks'], $decoded['docs'], $decoded['stats'])) {
            return null;
        }

        return $this->corpus = $decoded;
    }
}
