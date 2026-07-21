<?php

namespace App\Services\Yai;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Тонкий клиент OpenRouter (OpenAI-совместимый /chat/completions).
 * Модель задаётся в config/yai.php (env YAI_MODEL), по умолчанию Claude Haiku 4.5.
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
    public function chat(array $messages, int $maxTokens): ?array
    {
        try {
            $response = Http::withToken(config('yai.openrouter.api_key'))
                ->withHeaders([
                    // Рекомендуемая OpenRouter атрибуция приложения
                    'HTTP-Referer' => 'https://ampleev.com',
                    'X-Title' => 'YAI chat at ampleev.com',
                ])
                ->timeout((int) config('yai.openrouter.timeout', 60))
                ->post(rtrim(config('yai.openrouter.base_url'), '/') . '/chat/completions', [
                    'model' => config('yai.openrouter.model'),
                    'messages' => $messages,
                    'max_tokens' => $maxTokens,
                    'temperature' => 0.4,
                ]);

            if (!$response->ok()) {
                Log::warning('YAI: OpenRouter non-OK response', [
                    'status' => $response->status(),
                    'body' => mb_substr($response->body(), 0, 500),
                ]);
                return null;
            }

            $json = $response->json();
            $content = $json['choices'][0]['message']['content'] ?? null;
            if (!is_string($content) || trim($content) === '') {
                Log::warning('YAI: OpenRouter empty content', ['body' => mb_substr($response->body(), 0, 500)]);
                return null;
            }

            return [
                'content' => trim($content),
                'total_tokens' => (int) ($json['usage']['total_tokens'] ?? 0),
                'model' => (string) ($json['model'] ?? config('yai.openrouter.model')),
            ];
        } catch (\Throwable $e) {
            Log::warning('YAI: OpenRouter call failed', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
