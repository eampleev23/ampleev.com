<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogSection extends Model
{

    protected $table = 'blog_sections';
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getShortTitleForDisplayAttribute(): string
    {
        $short = trim((string) ($this->short_title ?? ''));
        if ($short !== '') {
            return $short;
        }

        return Str::limit((string) $this->title, 10, '');
    }
}
