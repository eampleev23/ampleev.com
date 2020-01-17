<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogSection extends Model
{

    protected $table = 'blog_sections';
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
