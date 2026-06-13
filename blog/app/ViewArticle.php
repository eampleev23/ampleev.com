<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewArticle extends Model
{

    protected $fillable = [
        'ip',
        'user_id',
        'is_owner',
        'owner_device_key',
        'owner_device_label',
    ];

    protected $casts = [
        'is_owner' => 'boolean',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
