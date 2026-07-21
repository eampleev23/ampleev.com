<?php

namespace App\Console\Commands;

use App\Services\Yai\Retriever;
use Illuminate\Console\Command;

class YaiEval extends Command
{
    protected $signature = 'yai:eval {--k=6 : Сколько чанков брать в выдачу (top-k)}';

    protected $description = 'Оценка качества ретривала «ЯAI» на золотом наборе вопросов: hit@k и MRR';

    public function handle(): int
    {
        $goldPath = storage_path('yai/gold_questions.json');
        if (!is_file($goldPath)) {
            $this->error('Нет файла ' . $goldPath);
            return self::FAILURE;
        }

        $retriever = new Retriever();
        if (!$retriever->corpusReady()) {
            $this->error('Корпус не собран — сначала php artisan yai:build-corpus');
            return self::FAILURE;
        }

        $gold = json_decode((string) file_get_contents($goldPath), true);
        $k = (int) $this->option('k');

        $hits = 0;
        $reciprocalRanks = [];
        $misses = [];

        foreach ($gold as $case) {
            $results = $retriever->search($case['q'], $k);
            $rank = null;
            foreach ($results as $i => $item) {
                if (in_array($item['doc']['id'], $case['expect'], true)) {
                    $rank = $i + 1;
                    break;
                }
            }

            if ($rank !== null) {
                $hits++;
                $reciprocalRanks[] = 1 / $rank;
                $this->line(sprintf('<info>hit@%d</info>  rank=%d  %s', $k, $rank, mb_substr($case['q'], 0, 70)));
            } else {
                $reciprocalRanks[] = 0;
                $top = $results[0]['doc']['id'] ?? '(пусто)';
                $misses[] = $case['q'];
                $this->line(sprintf('<comment>miss </comment>  top1=%s  %s', $top, mb_substr($case['q'], 0, 70)));
            }
        }

        $total = count($gold);
        $this->newLine();
        $this->info(sprintf(
            'hit@%d: %d/%d (%.0f%%)   MRR: %.3f',
            $k,
            $hits,
            $total,
            $total > 0 ? 100 * $hits / $total : 0,
            $total > 0 ? array_sum($reciprocalRanks) / $total : 0
        ));

        if ($misses !== []) {
            $this->newLine();
            $this->comment('Промахи: ' . implode(' | ', array_map(fn ($q) => mb_substr($q, 0, 40), $misses)));
        }

        return self::SUCCESS;
    }
}
