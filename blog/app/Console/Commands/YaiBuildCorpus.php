<?php

namespace App\Console\Commands;

use App\Services\Yai\CorpusBuilder;
use Illuminate\Console\Command;

class YaiBuildCorpus extends Command
{
    protected $signature = 'yai:build-corpus';

    protected $description = 'Собрать базу знаний «ЯAI» из драфтов статей и research-брифов в storage/yai/corpus.json';

    public function handle(): int
    {
        $stats = (new CorpusBuilder())->buildAndSave();

        $this->info(sprintf(
            'Корпус собран: %d документов, %d чанков, средняя длина чанка %.0f токенов, словарь %d термов.',
            $stats['doc_count'],
            $stats['chunk_count'],
            $stats['avgdl'],
            count($stats['df'])
        ));

        $vectors = $stats['vectors'] ?? [];
        if ($vectors['enabled'] ?? false) {
            $this->info(sprintf(
                'Векторы: %d измерений, из кэша %d, посчитано заново %d.',
                $vectors['dims'],
                $vectors['reused'],
                $vectors['embedded']
            ));
        } else {
            $this->comment('Векторы отключены (' . ($vectors['reason'] ?? 'unknown') . ') — поиск работает на чистом BM25.');
        }

        $this->line('Файл: ' . config('yai.corpus_path'));

        return self::SUCCESS;
    }
}
