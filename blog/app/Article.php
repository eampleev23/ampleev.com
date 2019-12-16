<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'seo_description',
        'content',
        'views_count',
        'likes_count',
        'blog_section_id',
    ];

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

    public function get_nice_time_created()
    {
        return MyTime::new_time($this->created_at);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function get_comments_counter()
    {
        return Comment::where(['article_id' => $this->id])->count();
    }

    public function viewsArticles()
    {
        return $this->hasMany(ViewArticle::class);
    }

    public function views_update()
    {

        $thisIp = Request::ip();
        $thisIpViews = ViewArticle::where([
            'article_id' => $this->id,
            'ip' => $thisIp,
        ])->count();

        if ($thisIpViews == 0) {

            if (Auth::check()) {

                $user_id = Auth::id();

                $this->viewsArticles()->create([
                    'user_id' => $user_id,
                    'ip' => $thisIp,
                ]);

            } else {

                $this->viewsArticles()->create([

                    'ip' => $thisIp,
                ]);
            }

            $this->views_count++;
            $this->save();

        }

        return true;

    }

}
