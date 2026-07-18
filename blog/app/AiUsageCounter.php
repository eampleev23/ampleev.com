<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AiUsageCounter extends Model
{
    private const DEFAULT_SOURCE_ID = 'default';
    private const SOURCE_HOST_SEPARATOR = '|';
    private const REBASE_MIN_DROP_TOKENS = 10000000;

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

    public static function applySnapshot(
        AiUsageSnapshot $snapshot,
        bool $ignoreSnapshotOrder = false,
        bool $useLock = true
    ): void
    {
        $apply = static function () use ($snapshot, $ignoreSnapshotOrder): void {
            $sourceId = self::counterSourceId($snapshot);

            DB::transaction(static function () use ($snapshot, $sourceId, $ignoreSnapshotOrder): void {
                foreach (self::providerTotals($snapshot) as $provider => $rawTotalTokens) {
                    self::applyProviderSnapshot($provider, $sourceId, $rawTotalTokens, $snapshot, $ignoreSnapshotOrder);
                }
            });
        };

        if (!$useLock) {
            $apply();
            return;
        }

        self::withCounterLock($apply);
    }

    public static function withCounterLock(callable $callback): void
    {
        $lockPath = storage_path('framework/ai-usage-counters.lock');
        $handle = fopen($lockPath, 'c');

        if (!$handle) {
            throw new \RuntimeException('Unable to open AI usage counter lock file.');
        }

        try {
            if (!flock($handle, LOCK_EX)) {
                throw new \RuntimeException('Unable to acquire AI usage counter lock.');
            }

            $callback();
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
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

    private static function counterSourceId(AiUsageSnapshot $snapshot): string
    {
        $logicalSourceId = self::normalizeSourceId($snapshot->source_id, $snapshot->source_host);
        $sourceHost = trim((string) $snapshot->source_host);

        if ($sourceHost === '' || $sourceHost === $logicalSourceId || !$snapshot->source_id) {
            return $logicalSourceId;
        }

        return mb_substr($logicalSourceId . self::SOURCE_HOST_SEPARATOR . $sourceHost, 0, 160);
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
            $logicalSourceId = self::normalizeSourceId($sourceId);
            $filtered = $counters->filter(static function (self $counter) use ($logicalSourceId): bool {
                return self::counterBelongsToSource((string) $counter->source_id, $logicalSourceId);
            });

            if ($filtered->isNotEmpty()) {
                return self::latestCounterPerProvider($filtered);
            }
        }

        return $counters
            ->groupBy(static function (self $counter): string {
                return $counter->provider . ':' . self::logicalCounterSourceId((string) $counter->source_id);
            })
            ->map(static function ($providerCounters) {
                return $providerCounters
                    ->sortByDesc('last_captured_at')
                    ->first();
            })
            ->filter()
            ->values();
    }

    private static function counterBelongsToSource(string $counterSourceId, string $logicalSourceId): bool
    {
        return $counterSourceId === $logicalSourceId
            || strpos($counterSourceId, $logicalSourceId . self::SOURCE_HOST_SEPARATOR) === 0;
    }

    private static function logicalCounterSourceId(string $counterSourceId): string
    {
        $separatorPosition = strpos($counterSourceId, self::SOURCE_HOST_SEPARATOR);

        if ($separatorPosition === false) {
            return $counterSourceId;
        }

        return substr($counterSourceId, 0, $separatorPosition);
    }

    private static function latestCounterPerProvider($counters)
    {
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
        AiUsageSnapshot $snapshot,
        bool $ignoreSnapshotOrder = false
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

        if (!$ignoreSnapshotOrder && $snapshot->id && $lastSnapshotId > 0 && (int) $snapshot->id <= $lastSnapshotId) {
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
        $rebaseDetected = false;

        if ($rawTotalTokens >= $previousRawTotal) {
            $delta = $rawTotalTokens - $previousRawTotal;
        } elseif ($rawTotalTokens > 0) {
            if (self::isLikelyRebase($previousRawTotal, $rawTotalTokens)) {
                // Local Codex/Claude history can be pruned or compacted.
                // Keep the lifetime total, but move the raw baseline down so future growth is counted.
                $delta = 0;
                $resetDetected = true;
                $rebaseDetected = true;
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

        $counter->raw_total_tokens = ($correctionDetected && !$rebaseDetected) ? $previousRawTotal : $rawTotalTokens;
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

    private static function isLikelyRebase(int $previousRawTotal, int $rawTotalTokens): bool
    {
        if ($previousRawTotal <= 0) {
            return false;
        }

        $drop = $previousRawTotal - $rawTotalTokens;

        return $drop >= self::REBASE_MIN_DROP_TOKENS;
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
