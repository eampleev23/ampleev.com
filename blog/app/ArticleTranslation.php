<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleTranslation extends Model
{
    protected $fillable = [
        'article_id',
        'locale',
        'text_url',
        'title',
        'seo_description',
        'html_title',
        'first_paragraph',
        'content',
        'main_image_path',
        'hero_image_path',
        'article_layout',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
