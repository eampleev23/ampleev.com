<?php

return [
    // Глобальный выключатель фичи «ЯAI» (страница отвечает 404, API — 503)
    'enabled' => env('YAI_ENABLED', true),

    'openrouter' => [
        'api_key' => env('OPENROUTER_API_KEY'),
        'base_url' => env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'),
        // Формат API провайдера: openai (chat/completions) или anthropic (v1/messages)
        'api_format' => env('YAI_API_FORMAT', 'openai'),
        'model' => env('YAI_MODEL', 'anthropic/claude-haiku-4.5'),
        'timeout' => (int) env('YAI_TIMEOUT', 60),
        // Прокси для исходящих запросов к LLM-провайдеру (например, когда хостинг
        // блокируется провайдером по IP). Формат: http://user:pass@host:port
        'proxy' => env('YAI_HTTP_PROXY'),
    ],

    'retrieval' => [
        'top_k' => 6,
        // Не более N чанков одного документа в выдаче — иначе один длинный текст вытесняет остальные
        'max_per_doc' => 2,
        'same_lang_boost' => 1.2,
    ],

    'limits' => [
        'max_message_chars' => 1200,
        'max_history_messages' => 8,
        'max_output_tokens' => 800,
        // Суточный потолок токенов (вход+выход) на весь сервис — защита бюджета OpenRouter
        'daily_token_budget' => (int) env('YAI_DAILY_TOKEN_BUDGET', 400000),
    ],

    'corpus_path' => storage_path('yai/corpus.json'),
    'persona_path' => storage_path('yai/persona.md'),
    'chat_log_dir' => storage_path('yai/chats'),

    // Слаги драфтов, которые не включаем в корпус (служебные/тестовые файлы)
    'exclude_drafts' => ['test1', 'basic_ru', 'specifica', 'calcburn', 'cumflowen'],

    // Включать ли research-брифы (рабочие материалы) в базу знаний
    'include_research' => true,
];
