<?php

namespace App\Services\Yai;

/**
 * Поиск релевантных чанков по вопросу пользователя: BM25 (k1=1.5, b=0.75)
 * поверх корпуса из storage/yai/corpus.json, с бустом чанков на языке вопроса
 * и ограничением «не более N чанков на документ».
 */
class Retriever
{
    private const K1 = 1.5;
    private const B = 0.75;

    private TextNormalizer $normalizer;

    /** @var array|null кэш корпуса на время запроса */
    private ?array $corpus = null;

    public function __construct()
    {
        $this->normalizer = new TextNormalizer();
    }

    public function corpusReady(): bool
    {
        return is_file(config('yai.corpus_path'));
    }

    /**
     * @return array<int, array{text: string, score: float, doc: array}>
     */
    public function search(string $query, ?int $topK = null): array
    {
        $corpus = $this->loadCorpus();
        if ($corpus === null) {
            return [];
        }

        $queryTokens = array_unique($this->normalizer->tokenize($query));
        if ($queryTokens === []) {
            return [];
        }

        $queryLang = $this->normalizer->isCyrillic($query) ? 'ru' : 'en';
        $topK = $topK ?? (int) config('yai.retrieval.top_k', 6);
        $maxPerDoc = (int) config('yai.retrieval.max_per_doc', 2);
        $langBoost = (float) config('yai.retrieval.same_lang_boost', 1.2);

        $df = $corpus['stats']['df'];
        $avgdl = max($corpus['stats']['avgdl'], 1);
        $n = count($corpus['chunks']);

        $docsById = [];
        foreach ($corpus['docs'] as $doc) {
            $docsById[$doc['id']] = $doc;
        }

        $scored = [];
        foreach ($corpus['chunks'] as $chunk) {
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

            if ($score <= 0) {
                continue;
            }

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
