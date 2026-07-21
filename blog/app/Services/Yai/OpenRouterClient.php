<?php

namespace App\Services\Yai;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Тонкий клиент LLM-провайдера. Поддерживает два формата API (env YAI_API_FORMAT):
 *  - openai    — OpenAI-совместимый /chat/completions (OpenRouter, ProxyAPI /openai/v1, VseGPT);
 *  - anthropic — нативный Anthropic Messages /v1/messages (ProxyAPI /anthropic).
 * Провайдер и модель задаются в config/yai.php (env OPENROUTER_BASE_URL / YAI_MODEL).
 */
class OpenRouterClient
{
    public function isConfigured(): bool
    {
        return (string) config('yai.openrouter.api_key') !== '';
    }

    /**
     * @param array<int, array{role: string, content: string}> $messages
     * @return array{content: string, total_tokens: int, model: string}|null null — при любой ошибке вызова
     */
    public function chat(array $messages, int $maxTokens, ?string $model = null): ?array
    {
        try {
            return config('yai.openrouter.api_format') === 'anthropic'
                ? $this->chatAnthropic($messages, $maxTokens, $model)
                : $this->chatOpenAi($messages, $maxTokens, $model);
        } catch (\Throwable $e) {
            Log::warning('YAI: LLM call failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function chatOpenAi(array $messages, int $maxTokens, ?string $model = null): ?array
    {
        $response = $this->baseRequest()->post($this->baseUrl() . '/chat/completions', [
            'model' => $model ?? config('yai.openrouter.model'),
            'messages' => $messages,
            'max_tokens' => $maxTokens,
            'temperature' => 0.4,
        ]);

        if (!$response->ok()) {
            return $this->logNonOk($response->status(), $response->body());
        }

        $json = $response->json();
        $content = $json['choices'][0]['message']['content'] ?? null;
        if (!is_string($content) || trim($content) === '') {
            return $this->logEmpty($response->body());
        }

        return [
            'content' => trim($content),
            'total_tokens' => (int) ($json['usage']['total_tokens'] ?? 0),
            'model' => (string) ($json['model'] ?? $model ?? config('yai.openrouter.model')),
        ];
    }

    private function chatAnthropic(array $messages, int $maxTokens, ?string $model = null): ?array
    {
        // Anthropic Messages API: системный промпт — отдельное поле, не сообщение
        $system = '';
        $chat = [];
        foreach ($messages as $message) {
            if ($message['role'] === 'system') {
                $system .= ($system === '' ? '' : "\n\n") . $message['content'];
                continue;
            }
            $chat[] = $message;
        }

        $response = $this->baseRequest()
            ->withHeaders(['anthropic-version' => '2023-06-01'])
            ->post($this->baseUrl() . '/v1/messages', [
                'model' => $model ?? config('yai.openrouter.model'),
                'max_tokens' => $maxTokens,
                'temperature' => 0.4,
                'system' => $system,
                'messages' => $chat,
            ]);

        if (!$response->ok()) {
            return $this->logNonOk($response->status(), $response->body());
        }

        $json = $response->json();
        $content = '';
        foreach (($json['content'] ?? []) as $block) {
            if (($block['type'] ?? '') === 'text') {
                $content .= $block['text'];
            }
        }
        if (trim($content) === '') {
            return $this->logEmpty($response->body());
        }

        $usage = $json['usage'] ?? [];

        return [
            'content' => trim($content),
            'total_tokens' => (int) ($usage['input_tokens'] ?? 0) + (int) ($usage['output_tokens'] ?? 0),
            'model' => (string) ($json['model'] ?? $model ?? config('yai.openrouter.model')),
        ];
    }

    private function baseRequest(): PendingRequest
    {
        $request = Http::withToken(config('yai.openrouter.api_key'))
            ->withHeaders([
                // Атрибуция приложения (OpenRouter её рекомендует, остальные игнорируют)
                'HTTP-Referer' => 'https://ampleev.com',
                'X-Title' => 'YAI chat at ampleev.com',
            ])
            ->timeout((int) config('yai.openrouter.timeout', 60));

        $proxy = (string) config('yai.openrouter.proxy');
        if ($proxy !== '') {
            $request = $request->withOptions(['proxy' => $proxy]);
        }

        return $request;
    }

    private function baseUrl(): string
    {
        return rtrim(config('yai.openrouter.base_url'), '/');
    }

    private function logNonOk(int $status, string $body): ?array
    {
        Log::warning('YAI: LLM non-OK response', [
            'status' => $status,
            'body' => mb_substr($body, 0, 500),
        ]);

        return null;
    }

    private function logEmpty(string $body): ?array
    {
        Log::warning('YAI: LLM empty content', ['body' => mb_substr($body, 0, 500)]);

        return null;
    }
}
