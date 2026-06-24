<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AiUsageCounter extends Model
{
    private const DEFAULT_SOURCE_ID = 'default';

    protected $fillable = [
        'provider',
        'source_id',
        'raw_total_tokens',
        'accumulated_tokens',
        'reset_count',
        'last_snapshot_id',
        'last_captured_at',
    ];

    protected $casts = [
        'raw_total_tokens' => 'integer',
        'accumulated_tokens' => 'integer',
        'reset_count' => 'integer',
        'last_snapshot_id' => 'integer',
        'last_captured_at' => 'datetime',
    ];

    public static function applySnapshot(AiUsageSnapshot $snapshot): void
    {
        $sourceId = self::normalizeSourceId($snapshot->source_id, $snapshot->source_host);

        DB::transaction(static function () use ($snapshot, $sourceId): void {
            foreach (self::providerTotals($snapshot) as $provider => $rawTotalTokens) {
                self::applyProviderSnapshot($provider, $sourceId, $rawTotalTokens, $snapshot);
            }
        });
    }

    public static function latestSummary(): ?AiUsageSnapshot
    {
        $counters = self::query()->get();

        if ($counters->isEmpty()) {
            return AiUsageSnapshot::latestSnapshot();
        }

        $codexTokens = (int) $counters
            ->where('provider', 'codex')
            ->sum('accumulated_tokens');
        $claudeTokens = (int) $counters
            ->where('provider', 'claude')
            ->sum('accumulated_tokens');
        $capturedAt = $counters
            ->pluck('last_captured_at')
            ->filter()
            ->max();

        return new AiUsageSnapshot([
            'total_tokens' => $codexTokens + $claudeTokens,
            'claude_tokens' => $claudeTokens,
            'codex_tokens' => $codexTokens,
            'captured_at' => $capturedAt instanceof Carbon ? $capturedAt : now(),
        ]);
    }

    public static function normalizeSourceId(?string $sourceId, ?string $sourceHost = null): string
    {
        $sourceId = trim((string) ($sourceId ?: $sourceHost ?: self::DEFAULT_SOURCE_ID));

        return mb_substr($sourceId !== '' ? $sourceId : self::DEFAULT_SOURCE_ID, 0, 160);
    }

    private static function providerTotals(AiUsageSnapshot $snapshot): array
    {
        return [
            'codex' => max(0, (int) $snapshot->codex_tokens),
            'claude' => max(0, (int) $snapshot->claude_tokens),
        ];
    }

    private static function applyProviderSnapshot(
        string $provider,
        string $sourceId,
        int $rawTotalTokens,
        AiUsageSnapshot $snapshot
    ): void {
        $counter = self::query()
            ->where('provider', $provider)
            ->where('source_id', $sourceId)
            ->lockForUpdate()
            ->first();

        if (!$counter) {
            self::query()->create([
                'provider' => $provider,
                'source_id' => $sourceId,
                'raw_total_tokens' => $rawTotalTokens,
                'accumulated_tokens' => $rawTotalTokens,
                'reset_count' => 0,
                'last_snapshot_id' => $snapshot->id,
                'last_captured_at' => $snapshot->captured_at ?: now(),
            ]);

            return;
        }

        $previousRawTotal = (int) $counter->raw_total_tokens;
        $lastSnapshotId = (int) $counter->last_snapshot_id;

        if ($snapshot->id && $lastSnapshotId > 0 && (int) $snapshot->id <= $lastSnapshotId) {
            if (
                $snapshot->captured_at
                && (!$counter->last_captured_at || $snapshot->captured_at->greaterThan($counter->last_captured_at))
            ) {
                $counter->last_captured_at = $snapshot->captured_at;
                $counter->save();
            }

            return;
        }

        if ($rawTotalTokens >= $previousRawTotal) {
            $delta = $rawTotalTokens - $previousRawTotal;
        } elseif ($rawTotalTokens > 0) {
            // Local Codex/Claude history can be pruned. Treat a non-zero drop as a new segment.
            $delta = $rawTotalTokens;
            $counter->reset_count = (int) $counter->reset_count + 1;
        } else {
            // A zero drop is usually a temporary read/configuration failure. Do not lower the counter.
            return;
        }

        $counter->raw_total_tokens = $rawTotalTokens;
        $counter->accumulated_tokens = (int) $counter->accumulated_tokens + $delta;
        $counter->last_snapshot_id = $snapshot->id;
        $counter->last_captured_at = $snapshot->captured_at ?: now();
        $counter->save();
    }
}
