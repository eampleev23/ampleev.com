<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OwnerDevice extends Model
{
    protected $fillable = [
        'key',
        'label',
        'user_id',
        'is_active',
        'claimed_at',
        'last_seen_at',
        'user_agent',
        'ip_hash',
        'device_type',
        'platform_name',
        'browser_name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'claimed_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
