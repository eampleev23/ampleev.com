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

    public function tweetHrefGenerate()
    {
        $result = "https://twitter.com/intent/tweet?text=";
        $result .= $this->title;
        $result .= " ";
        $result .= route('blog.show_article', $this->id);
//        return "https://twitter.com/intent/tweet?text=Диаграммы%20сгорания%20в%20контексте%20SAFe%20-%20https://www.ampleev.com/blog-article";
        return $result;
    }

    public function views_update()
    {

        $thisIp = Request::ip();
        $isAuth = Auth::check();

        if ($isAuth) {

            // авторизованный пользователь

            $user_id = Auth::id();

            $thisUserViews = ViewArticle::where([
                'article_id' => $this->id,
                'user_id' => $user_id,
            ])->count();

            if ($thisUserViews == 0) {
                // этот пользователь еще не просматривал данную статью
                $this->views_count++;
                $this->save();
                $this->viewsArticles()->create([
                    'user_id' => $user_id,
                    'ip' => $thisIp,
                ]);
            } else {
                // этот пользователь уже просматривал данную статью
                return true;
            }

        } else {

            //не авторизованный пользователь

            $thisIpViews = ViewArticle::where([
                'article_id' => $this->id,
                'ip' => $thisIp,
            ])->count();

            if ($thisIpViews == 0) {
                // этот пользователь еще не просматривал данную статью
                $this->views_count++;
                $this->save();
                $this->viewsArticles()->create([
                    'ip' => $thisIp,
                ]);
            } else {
                return true;
            }
        }

        return true;

    }

}
