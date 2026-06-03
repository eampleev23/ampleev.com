<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleReadSession extends Model
{
    protected $fillable = [
        'article_id',
        'view_article_id',
        'user_id',
        'session_key',
        'ip',
        'user_agent',
        'locale',
        'device_type',
        'source_type',
        'referer',
        'first_url',
        'last_url',
        'max_scroll_percent',
        'reached_25',
        'reached_50',
        'reached_75',
        'reached_100',
        'active_seconds',
        'viewport_width',
        'viewport_height',
        'screen_width',
        'screen_height',
        'started_at',
        'last_seen_at',
    ];

    protected $casts = [
        'reached_25' => 'boolean',
        'reached_50' => 'boolean',
        'reached_75' => 'boolean',
        'reached_100' => 'boolean',
        'started_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function viewArticle()
    {
        return $this->belongsTo(ViewArticle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
