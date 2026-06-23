<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AiUsageSnapshot extends Model
{
    protected $fillable = [
        'total_tokens',
        'claude_tokens',
        'codex_tokens',
        'captured_at',
        'source_host',
        'source_id',
        'payload_hash',
        'provider_payload',
    ];

    protected $casts = [
        'total_tokens' => 'integer',
        'claude_tokens' => 'integer',
        'codex_tokens' => 'integer',
        'captured_at' => 'datetime',
        'provider_payload' => 'array',
    ];

    public static function latestSnapshot(): ?self
    {
        return self::orderByDesc('captured_at')
            ->orderByDesc('id')
            ->first();
    }
}
