<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalLinkVisit extends Model
{
    protected $fillable = [
        'source',
        'target_path',
        'target_url',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'referer',
        'user_agent',
        'ip_hash',
        'user_id',
        'is_admin',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
