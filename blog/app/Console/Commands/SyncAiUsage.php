<?php

namespace App\Console\Commands;

use App\AiUsageSnapshot;
use App\AiUsageCounter;
use App\Services\AiUsageAggregator;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class SyncAiUsage extends Command
{
    protected $signature = 'ai-usage:sync
        {--home= : Home directory containing .codex and .claude}
        {--endpoint= : Sync endpoint, defaults to AI_USAGE_SYNC_ENDPOINT or APP_URL/api/internal/ai-usage/sync}
        {--token= : Sync token, defaults to AI_USAGE_SYNC_TOKEN}
        {--dry-run : Print aggregated payload without storing or sending}
        {--store-local : Store snapshot in the current database instead of sending it}
        {--watch : Keep syncing until the process is stopped}
        {--interval=15 : Seconds between sync attempts in watch mode}';

    protected $description = 'Aggregate local Codex/Claude token usage and sync only totals to Ampleev.com.';

    public function handle(AiUsageAggregator $aggregator): int
    {
        if ($this->option('watch')) {
            $interval = max(5, (int) $this->option('interval'));
            $this->info('Watching AI usage every ' . $interval . ' seconds. Press Ctrl+C to stop.');

            while (true) {
                $this->syncOnce($aggregator);
                sleep($interval);
            }
        }

        return $this->syncOnce($aggregator);
    }

    private function syncOnce(AiUsageAggregator $aggregator): int
    {
        $payload = $aggregator->aggregate($this->option('home') ?: null);

        $this->line('AI usage snapshot');
        $this->line('Total:  ' . number_format($payload['total_tokens'], 0, '.', ' '));
        $this->line('Claude: ' . number_format($payload['claude_tokens'], 0, '.', ' '));
        $this->line('Codex:  ' . number_format($payload['codex_tokens'], 0, '.', ' '));
        $this->line('Source: ' . ($payload['source_id'] ?? $payload['source_host'] ?? 'default'));

        if ($this->option('dry-run')) {
            $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            return self::SUCCESS;
        }

        if ($this->option('store-local')) {
            $snapshot = $this->storeLocalSnapshot($payload);
            $this->info('Stored local snapshot #' . $snapshot->id . '.');
            return self::SUCCESS;
        }

        $endpoint = $this->syncEndpoint();
        $token = (string) ($this->option('token') ?: config('services.ai_usage.sync_token'));

        if ($endpoint === '' || $token === '') {
            $this->error('Endpoint and token are required. Use --endpoint/--token or AI_USAGE_SYNC_ENDPOINT/AI_USAGE_SYNC_TOKEN.');
            return self::FAILURE;
        }

        $response = Http::withToken($token)
            ->acceptJson()
            ->timeout(15)
            ->post($endpoint, $payload);

        if (!$response->successful()) {
            $this->error('Sync failed: HTTP ' . $response->status());
            $this->line($response->body());
            return self::FAILURE;
        }

        $this->info('Synced successfully.');
        $this->line($response->body());

        return self::SUCCESS;
    }

    private function syncEndpoint(): string
    {
        $endpoint = (string) ($this->option('endpoint') ?: config('services.ai_usage.sync_endpoint'));
        if ($endpoint !== '') {
            return $endpoint;
        }

        $appUrl = rtrim((string) config('app.url'), '/');
        if ($appUrl === '') {
            return '';
        }

        return $appUrl . '/api/internal/ai-usage/sync';
    }

    private function storeLocalSnapshot(array $payload): AiUsageSnapshot
    {
        $payloadHash = $this->payloadHash($payload);

        $snapshot = AiUsageSnapshot::firstOrCreate(
            ['payload_hash' => $payloadHash],
            [
                'total_tokens' => (int) $payload['total_tokens'],
                'claude_tokens' => (int) $payload['claude_tokens'],
                'codex_tokens' => (int) $payload['codex_tokens'],
                'captured_at' => Carbon::parse($payload['captured_at']),
                'source_host' => $payload['source_host'] ?? null,
                'source_id' => AiUsageCounter::normalizeSourceId($payload['source_id'] ?? null, $payload['source_host'] ?? null),
                'provider_payload' => $payload['providers'] ?? [],
            ]
        );

        AiUsageCounter::applySnapshot($snapshot);

        return $snapshot;
    }

    private function payloadHash(array $payload): string
    {
        unset($payload['captured_at'], $payload['source_host']);

        return hash('sha256', json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
