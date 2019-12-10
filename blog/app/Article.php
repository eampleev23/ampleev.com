<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $table = 'articles';
    protected $guarded = [];

    /**
     * Get the author of the post.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function blog_section()
    {
        return $this->belongsTo('App\BlogSection');
    }
}
