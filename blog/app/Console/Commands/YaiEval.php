<?php

namespace App\Console\Commands;

use App\Services\Yai\Retriever;
use App\Services\Yai\YaiChatService;
use Illuminate\Console\Command;

class YaiEval extends Command
{
    protected $signature = 'yai:eval
        {--k=4 : Сколько чанков брать в выдачу (top-k, по умолчанию как на проде)}
        {--compare : Дополнительно прогнать чистый BM25 для сравнения с гибридом}
        {--chain : Диалоговый eval — переформулировка с историей + поиск (gold_conversations.json)}';

    protected $description = 'Оценка качества ретривала «AIЯ» на золотых наборах: hit@k и MRR';

    public function handle(): int
    {
        $retriever = new Retriever();
        if (!$retriever->corpusReady()) {
            $this->error('Корпус не собран — сначала php artisan yai:build-corpus');
            return self::FAILURE;
        }

        return $this->option('chain')
            ? $this->chainEval($retriever)
            : $this->retrievalEval($retriever);
    }

    private function retrievalEval(Retriever $retriever): int
    {
        $goldPath = storage_path('yai/gold_questions.json');
        if (!is_file($goldPath)) {
            $this->error('Нет файла ' . $goldPath);
            return self::FAILURE;
        }

        $gold = json_decode((string) file_get_contents($goldPath), true);
        $k = (int) $this->option('k');

        $modes = $this->option('compare')
            ? ['гибрид' => false, 'bm25' => true]
            : ['поиск' => false];

        foreach ($modes as $label => $bm25Only) {
            $hits = 0;
            $reciprocalRanks = [];
            $misses = [];

            foreach ($gold as $case) {
                $results = $retriever->search($case['q'], $k, $bm25Only);
                $rank = $this->rankOfExpected($results, $case['expect']);

                if ($rank !== null) {
                    $hits++;
                    $reciprocalRanks[] = 1 / $rank;
                } else {
                    $reciprocalRanks[] = 0;
                    $misses[] = mb_substr($case['q'], 0, 45);
                }
            }

            $total = count($gold);
            $this->info(sprintf(
                '[%s] hit@%d: %d/%d (%.0f%%)   MRR: %.3f',
                $label,
                $k,
                $hits,
                $total,
                $total > 0 ? 100 * $hits / $total : 0,
                $total > 0 ? array_sum($reciprocalRanks) / $total : 0
            ));
            if ($misses !== []) {
                $this->comment('  промахи: ' . implode(' | ', $misses));
            }
        }

        return self::SUCCESS;
    }

    private function chainEval(Retriever $retriever): int
    {
        $goldPath = storage_path('yai/gold_conversations.json');
        if (!is_file($goldPath)) {
            $this->error('Нет файла ' . $goldPath);
            return self::FAILURE;
        }

        $gold = json_decode((string) file_get_contents($goldPath), true);
        $k = (int) $this->option('k');
        $service = new YaiChatService();

        $hits = 0;
        foreach ($gold as $case) {
            $query = $service->rewriteSearchQuery($case['message'], $case['history']) ?? $case['message'];
            $results = $retriever->search($query, $k);
            $rank = $this->rankOfExpected($results, $case['expect']);

            $status = $rank !== null ? "<info>hit rank={$rank}</info>" : '<comment>miss</comment>';
            $this->line(sprintf('%s  «%s»', $status, mb_substr($case['message'], 0, 40)));
            $this->line('      → ' . mb_substr($query, 0, 110));
            if ($rank !== null) {
                $hits++;
            }
        }

        $total = count($gold);
        $this->newLine();
        $this->info(sprintf('chain hit@%d: %d/%d (%.0f%%)', $k, $hits, $total, $total > 0 ? 100 * $hits / $total : 0));

        return self::SUCCESS;
    }

    /**
     * @return int|null 1-based ранг первого ожидаемого документа в выдаче
     */
    private function rankOfExpected(array $results, array $expected): ?int
    {
        foreach ($results as $i => $item) {
            if (in_array($item['doc']['id'], $expected, true)) {
                return $i + 1;
            }
        }

        return null;
    }
}
