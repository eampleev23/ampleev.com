<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AiUsageCounter extends Model
{
    private const DEFAULT_SOURCE_ID = 'default';
    private const RESET_DROP_RATIO = 0.65;
    private const RESET_MIN_DROP_TOKENS = 100000000;

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
        $counters = self::summaryCounters();

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

    private static function summaryCounters()
    {
        $counters = self::query()->get();
        $sourceId = trim((string) config('services.ai_usage.source_id'));

        if ($sourceId !== '') {
            $filtered = $counters->where('source_id', self::normalizeSourceId($sourceId));

            if ($filtered->isNotEmpty()) {
                return $filtered;
            }
        }

        return $counters
            ->groupBy('provider')
            ->map(static function ($providerCounters) {
                return $providerCounters
                    ->sortByDesc('last_captured_at')
                    ->first();
            })
            ->filter()
            ->values();
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
            $counter = self::query()->create([
                'provider' => $provider,
                'source_id' => $sourceId,
                'raw_total_tokens' => $rawTotalTokens,
                'accumulated_tokens' => $rawTotalTokens,
                'reset_count' => 0,
                'last_snapshot_id' => $snapshot->id,
                'last_captured_at' => $snapshot->captured_at ?: now(),
            ]);

            self::recordDelta($provider, $sourceId, null, $rawTotalTokens, 0, $counter, $snapshot);

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

        $resetDetected = false;
        $correctionDetected = false;

        if ($rawTotalTokens >= $previousRawTotal) {
            $delta = $rawTotalTokens - $previousRawTotal;
        } elseif ($rawTotalTokens > 0) {
            if (self::isLikelyReset($previousRawTotal, $rawTotalTokens)) {
                // Local Codex/Claude history can be pruned. Treat a large drop as a new segment.
                $delta = $rawTotalTokens;
                $resetDetected = true;
                $counter->reset_count = (int) $counter->reset_count + 1;
            } else {
                // Small drops are usually source recalculations. Keep the high-water mark.
                $delta = 0;
                $correctionDetected = true;
            }
        } else {
            // A zero drop is usually a temporary read/configuration failure. Do not lower the counter.
            $delta = 0;
            $correctionDetected = true;
        }

        $counter->raw_total_tokens = $correctionDetected ? $previousRawTotal : $rawTotalTokens;
        $counter->accumulated_tokens = (int) $counter->accumulated_tokens + $delta;
        $counter->last_snapshot_id = $snapshot->id;
        $counter->last_captured_at = $snapshot->captured_at ?: now();
        $counter->save();

        self::recordDelta(
            $provider,
            $sourceId,
            $previousRawTotal,
            $rawTotalTokens,
            $delta,
            $counter,
            $snapshot,
            $resetDetected,
            $correctionDetected
        );
    }

    private static function isLikelyReset(int $previousRawTotal, int $rawTotalTokens): bool
    {
        if ($previousRawTotal <= 0) {
            return false;
        }

        $drop = $previousRawTotal - $rawTotalTokens;

        return $drop >= self::RESET_MIN_DROP_TOKENS
            && ($rawTotalTokens / $previousRawTotal) <= self::RESET_DROP_RATIO;
    }

    private static function recordDelta(
        string $provider,
        string $sourceId,
        ?int $previousRawTotal,
        int $rawTotalTokens,
        int $delta,
        self $counter,
        AiUsageSnapshot $snapshot,
        bool $resetDetected = false,
        bool $correctionDetected = false
    ): void {
        AiUsageDelta::updateOrCreate(
            [
                'snapshot_id' => $snapshot->id,
                'provider' => $provider,
                'source_id' => $sourceId,
            ],
            [
                'previous_raw_total_tokens' => $previousRawTotal,
                'raw_total_tokens' => $rawTotalTokens,
                'delta_tokens' => max(0, $delta),
                'accumulated_tokens' => (int) $counter->accumulated_tokens,
                'reset_detected' => $resetDetected,
                'correction_detected' => $correctionDetected,
                'captured_at' => $snapshot->captured_at ?: now(),
            ]
        );
    }
}
