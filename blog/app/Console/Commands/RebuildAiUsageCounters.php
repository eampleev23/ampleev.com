<?php

namespace App\Console\Commands;

use App\AiUsageCounter;
use App\AiUsageDelta;
use App\AiUsageSnapshot;
use Illuminate\Console\Command;

class RebuildAiUsageCounters extends Command
{
    protected $signature = 'ai-usage:rebuild-counters {--yes : Run without confirmation}';

    protected $description = 'Rebuild AI usage counters and per-snapshot deltas from stored snapshots.';

    public function handle(): int
    {
        if (!$this->option('yes') && !$this->confirm('Rebuild AI usage counters and deltas from snapshots?')) {
            $this->warn('Cancelled.');
            return self::SUCCESS;
        }

        AiUsageDelta::query()->delete();
        AiUsageCounter::query()->delete();

        $count = 0;

        AiUsageSnapshot::query()
            ->orderBy('captured_at')
            ->orderBy('id')
            ->chunk(200, function ($snapshots) use (&$count): void {
                foreach ($snapshots as $snapshot) {
                    AiUsageCounter::applySnapshot($snapshot, ignoreSnapshotOrder: true);
                    $count++;
                }
            });

        $this->info('Rebuilt AI usage from ' . $count . ' snapshots.');
        $this->table(
            ['provider', 'source_id', 'raw_total_tokens', 'accumulated_tokens', 'reset_count', 'last_captured_at'],
            AiUsageCounter::query()
                ->orderBy('provider')
                ->orderBy('source_id')
                ->get(['provider', 'source_id', 'raw_total_tokens', 'accumulated_tokens', 'reset_count', 'last_captured_at'])
                ->map(static function (AiUsageCounter $counter): array {
                    return [
                        $counter->provider,
                        $counter->source_id,
                        $counter->raw_total_tokens,
                        $counter->accumulated_tokens,
                        $counter->reset_count,
                        optional($counter->last_captured_at)->toDateTimeString(),
                    ];
                })
                ->toArray()
        );

        $this->line('Delta rows: ' . AiUsageDelta::query()->count());

        return self::SUCCESS;
    }
}
