<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use DOMDocument;
use DOMXPath;

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
        return $this->belongsTo(User::class);
    }

    public function blog_section()
    {
        return $this->belongsTo(BlogSection::class);
    }

    public function get_nice_time_created()
    {
        return MyTime::new_time($this->created_at);
    }

    public function get_nice_day_created()
    {
        return MyTime::new_day($this->created_at);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @deprecated Используйте withCount('comments') в запросах вместо этого метода
     */
    public function get_comments_counter()
    {
        return $this->comments()->count();
    }

    public function viewsArticles()
    {
        return $this->hasMany(ViewArticle::class);
    }

    public function tweetHrefGenerate()
    {
        $url = route('blog.show_article', $this->text_url);
        $text = $this->title;

        // Используем twitter.com, чтобы iOS-клиент открывал окно публикации, а не ленту
        return "https://twitter.com/intent/tweet?url=" . urlencode($url) . "&text=" . urlencode($text);
    }

    public function telegramHrefGenerate()
    {
        $url = route('blog.show_article', $this->text_url);
        $text = $this->title;

        // rawurlencode сохраняет пробелы как %20, чтобы Telegram не заменял их на +
        return "https://t.me/share/url?url=" . urlencode($url) . "&text=" . rawurlencode($text);
    }

    public function isMainImageZoomEnabled(): bool
    {
        // По умолчанию сохраняем текущее поведение (zoom), чтобы старые статьи не поменялись неожиданно
        return ($this->main_image_mode ?? 'zoom') === 'zoom';
    }

    public function firstParagraphForDisplay(): string
    {
        return $this->applyImageModeToHtml($this->first_paragraph ?? '');
    }

    public function contentForDisplay(): string
    {
        return $this->applyImageModeToHtml($this->content ?? '');
    }

    private function applyImageModeToHtml(string $html): string
    {
        if (!$this->isMainImageZoomEnabled()) {
            return $html;
        }

        return $this->wrapImagesWithFancybox($html, 'article-images');
    }

    private function wrapImagesWithFancybox(string $html, string $galleryName): string
    {
        $html = trim($html);
        if ($html === '') {
            return $html;
        }

        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8"><div id="__root__">' . $html . '</div>');
        $xpath = new DOMXPath($dom);

        $imgNodes = $xpath->query('//div[@id="__root__"]//img');
        if (!$imgNodes || $imgNodes->length === 0) {
            return $html;
        }

        // NodeList "живой", поэтому собираем в массив
        $images = [];
        foreach ($imgNodes as $img) {
            $images[] = $img;
        }

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (!$src) {
                continue;
            }

            // Не трогаем изображения, которые уже обернуты ссылкой
            $parent = $img->parentNode;
            if ($parent && $parent->nodeName === 'a') {
                continue;
            }

            // Создаем <a> и оборачиваем img
            $a = $dom->createElement('a');
            $a->setAttribute('href', $src);
            $a->setAttribute('data-fancybox', $galleryName);

            $alt = $img->getAttribute('alt');
            if ($alt) {
                $a->setAttribute('data-caption', $alt);
            }

            $clonedImg = $img->cloneNode(true);
            $a->appendChild($clonedImg);

            if ($parent) {
                $parent->replaceChild($a, $img);
            }
        }

        $root = $dom->getElementById('__root__');
        if (!$root) {
            return $html;
        }

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $dom->saveHTML($child);
        }

        return $out;
    }

    public function views_update()
    {
        $thisIp = Request::ip();
        $isAuth = Auth::check();
        $user_id = $isAuth ? Auth::id() : null;

        // Используем транзакцию для предотвращения race condition
        return DB::transaction(function () use ($thisIp, $user_id) {
            // Для авторизованных пользователей проверяем по user_id
            // Для неавторизованных - по IP
            // Но также проверяем, чтобы не было дубликатов при переходе из неавторизованного в авторизованного состояния
            
            $query = ViewArticle::where('article_id', $this->id);
            
            if ($user_id) {
                // Авторизованный пользователь: проверяем по user_id
                $existingView = $query->where('user_id', $user_id)->lockForUpdate()->first();
                
                if ($existingView) {
                    // Пользователь уже просматривал эту статью
                    return true;
                }
                
                // Также проверяем по IP на случай, если пользователь ранее просматривал неавторизованным
                $existingViewByIp = ViewArticle::where('article_id', $this->id)
                    ->where('ip', $thisIp)
                    ->whereNull('user_id')
                    ->lockForUpdate()
                    ->first();
                
                if ($existingViewByIp) {
                    // Обновляем существующую запись, добавляя user_id
                    $existingViewByIp->user_id = $user_id;
                    $existingViewByIp->save();
                    return true;
                }
            } else {
                // Неавторизованный пользователь: проверяем по IP
                $existingView = $query->where('ip', $thisIp)->lockForUpdate()->first();
                
                if ($existingView) {
                    // Этот IP уже просматривал статью
                    return true;
                }
            }
            
            // Создаем новую запись о просмотре
            $this->viewsArticles()->create([
                'user_id' => $user_id,
                'ip' => $thisIp,
            ]);
            
            // Увеличиваем счетчик просмотров
            $this->increment('views_count');
            
            return true;
        });
    }

    public static function getRandomLink()
    {
        return Article::where('confirmed', '=', '1')
            ->where('type_article', '=', 'link')
            ->inRandomOrder()
            ->first();
    }

    public static function getRandomArticles($article_id, $quantity = 2)
    {
        // Оптимизированная версия: используем inRandomOrder() вместо загрузки всех статей
        return Article::with(['user', 'blog_section'])
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', 'article')
            ->where('id', '!=', $article_id)
            ->inRandomOrder()
            ->limit($quantity)
            ->get();
    }

    public function isMobile()
    {
        $agent = new Agent();
        return $agent->isMobile();
    }
}
