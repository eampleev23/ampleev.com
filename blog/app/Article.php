<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

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
        'html_title',
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
        $result .= route('blog.show_article', $this->text_url);
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

    public static function getRandomLink()
    {
        $allLinks = Article::orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', 'link')
            ->get();

        $randomNumber = random_int(0, count($allLinks) - 1);
        return $allLinks[$randomNumber];
    }

    public static function getRandomArticles($quantity = 2, $article_id)
    {
        $allArticles = Article::orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', 'article')
            ->where('id', '!=', $article_id)
            ->limit(100)
            ->get();

        // Если нет доступных статей
        if ($allArticles->isEmpty()) {
            return collect();
        }

        // Если запрашиваемое количество больше или равно доступному
        if ($quantity >= $allArticles->count()) {
            return $allArticles;
        }

        $random_articles = collect();
        $usedIndexes = [];

        while ($random_articles->count() < $quantity && count($usedIndexes) < $allArticles->count()) {
            $randomIndex = random_int(0, $allArticles->count() - 1);

            // Пропускаем уже использованные индексы
            if (in_array($randomIndex, $usedIndexes)) {
                continue;
            }

            $usedIndexes[] = $randomIndex;
            $random_articles->push($allArticles[$randomIndex]);
        }

        return $random_articles;
    }

    public function isMobile()
    {
        $agent = new Agent();
        return $agent->isMobile();
    }
}
