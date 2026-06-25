<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AiUsageDelta extends Model
{
    protected $fillable = [
        'snapshot_id',
        'provider',
        'source_id',
        'previous_raw_total_tokens',
        'raw_total_tokens',
        'delta_tokens',
        'accumulated_tokens',
        'reset_detected',
        'correction_detected',
        'captured_at',
    ];

    protected $casts = [
        'snapshot_id' => 'integer',
        'previous_raw_total_tokens' => 'integer',
        'raw_total_tokens' => 'integer',
        'delta_tokens' => 'integer',
        'accumulated_tokens' => 'integer',
        'reset_detected' => 'boolean',
        'correction_detected' => 'boolean',
        'captured_at' => 'datetime',
    ];
}
