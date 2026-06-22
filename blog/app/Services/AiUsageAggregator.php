<?php

namespace App\Services;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileObject;

class AiUsageAggregator
{
    public function aggregate(?string $home = null): array
    {
        $home = $home ?: (string) ($_SERVER['HOME'] ?? getenv('HOME') ?: '');
        $codex = $this->aggregateCodex($home);
        $claude = $this->aggregateClaude($home);

        $totalTokens = $codex['total_tokens'] + $claude['total_tokens'];

        return [
            'total_tokens' => $totalTokens,
            'claude_tokens' => $claude['total_tokens'],
            'codex_tokens' => $codex['total_tokens'],
            'captured_at' => now()->toIso8601String(),
            'source_host' => gethostname() ?: null,
            'providers' => [
                'codex' => $codex,
                'claude' => $claude,
            ],
        ];
    }

    private function aggregateCodex(string $home): array
    {
        $totalsBySession = [];
        $files = array_merge(
            $this->jsonlFiles($home . '/.codex/archived_sessions'),
            $this->jsonlFiles($home . '/.codex/sessions')
        );

        foreach ($files as $filePath) {
            $sessionId = null;
            $lastUsage = null;

            foreach ($this->readJsonLines($filePath) as $entry) {
                if (($entry['type'] ?? null) === 'session_meta') {
                    $sessionId = $entry['payload']['id'] ?? $sessionId;
                }

                if (($entry['type'] ?? null) !== 'event_msg') {
                    continue;
                }

                $payload = $entry['payload'] ?? [];
                if (($payload['type'] ?? null) !== 'token_count') {
                    continue;
                }

                $usage = $payload['info']['total_token_usage'] ?? null;
                if (is_array($usage)) {
                    $lastUsage = $this->normalizeCodexUsage($usage);
                }
            }

            if ($lastUsage === null) {
                continue;
            }

            $sessionKey = $sessionId ?: sha1($filePath);
            if (!isset($totalsBySession[$sessionKey]) || $lastUsage['total_tokens'] > $totalsBySession[$sessionKey]['total_tokens']) {
                $totalsBySession[$sessionKey] = $lastUsage;
            }
        }

        return array_merge(
            $this->sumUsage($totalsBySession),
            [
                'session_count' => count($totalsBySession),
                'file_count' => count($files),
            ]
        );
    }

    private function aggregateClaude(string $home): array
    {
        $usageByRequest = [];
        $files = $this->jsonlFiles($home . '/.claude/projects');

        foreach ($files as $filePath) {
            foreach ($this->readJsonLines($filePath) as $entry) {
                if (($entry['type'] ?? null) !== 'assistant') {
                    continue;
                }

                $usage = $entry['message']['usage'] ?? null;
                if (!is_array($usage)) {
                    continue;
                }

                $requestKey = $entry['requestId']
                    ?? $entry['message']['id']
                    ?? $entry['uuid']
                    ?? sha1($filePath . ':' . json_encode($usage));

                if (!isset($usageByRequest[$requestKey])) {
                    $usageByRequest[$requestKey] = $this->normalizeClaudeUsage($usage);
                }
            }
        }

        return array_merge(
            $this->sumUsage($usageByRequest),
            [
                'request_count' => count($usageByRequest),
                'file_count' => count($files),
            ]
        );
    }

    private function normalizeCodexUsage(array $usage): array
    {
        return [
            'input_tokens' => (int) ($usage['input_tokens'] ?? 0),
            'cached_input_tokens' => (int) ($usage['cached_input_tokens'] ?? 0),
            'cache_creation_input_tokens' => 0,
            'cache_read_input_tokens' => 0,
            'output_tokens' => (int) ($usage['output_tokens'] ?? 0),
            'reasoning_output_tokens' => (int) ($usage['reasoning_output_tokens'] ?? 0),
            'total_tokens' => (int) ($usage['total_tokens'] ?? 0),
        ];
    }

    private function normalizeClaudeUsage(array $usage): array
    {
        $inputTokens = (int) ($usage['input_tokens'] ?? 0);
        $cacheCreationTokens = (int) ($usage['cache_creation_input_tokens'] ?? 0);
        $cacheReadTokens = (int) ($usage['cache_read_input_tokens'] ?? 0);
        $outputTokens = (int) ($usage['output_tokens'] ?? 0);

        return [
            'input_tokens' => $inputTokens,
            'cached_input_tokens' => $cacheCreationTokens + $cacheReadTokens,
            'cache_creation_input_tokens' => $cacheCreationTokens,
            'cache_read_input_tokens' => $cacheReadTokens,
            'output_tokens' => $outputTokens,
            'reasoning_output_tokens' => 0,
            'total_tokens' => $inputTokens + $cacheCreationTokens + $cacheReadTokens + $outputTokens,
        ];
    }

    private function sumUsage(array $items): array
    {
        $sum = [
            'input_tokens' => 0,
            'cached_input_tokens' => 0,
            'cache_creation_input_tokens' => 0,
            'cache_read_input_tokens' => 0,
            'output_tokens' => 0,
            'reasoning_output_tokens' => 0,
            'total_tokens' => 0,
        ];

        foreach ($items as $usage) {
            foreach ($sum as $field => $value) {
                $sum[$field] += (int) ($usage[$field] ?? 0);
            }
        }

        return $sum;
    }

    private function jsonlFiles(string $directory): array
    {
        if (!is_dir($directory)) {
            return [];
        }

        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (!$file->isFile() || strtolower($file->getExtension()) !== 'jsonl') {
                continue;
            }

            $files[] = $file->getPathname();
        }

        sort($files);

        return $files;
    }

    private function readJsonLines(string $filePath): iterable
    {
        $file = new SplFileObject($filePath, 'r');

        while (!$file->eof()) {
            $line = trim((string) $file->fgets());
            if ($line === '') {
                continue;
            }

            $decoded = json_decode($line, true);
            if (is_array($decoded)) {
                yield $decoded;
            }
        }
    }
}
