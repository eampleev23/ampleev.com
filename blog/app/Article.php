<?php

namespace App;

use App\Support\SiteLocale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class Article extends Model
{
    public const LAYOUT_CLASSIC = 'classic';
    public const LAYOUT_IMAGE_HEADER = 'image-header';
    public const LAYOUT_PARALLAX = 'parallax';

    protected $fillable = [
        'title',
        'user_id',
        'seo_description',
        'content',
        'views_count',
        'likes_count',
        'blog_section_id',
        'html_title',
        'show_feedback_questions',
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

    public function translations()
    {
        return $this->hasMany(ArticleTranslation::class);
    }

    public function translation(?string $locale = null): ?ArticleTranslation
    {
        $locale = SiteLocale::normalize($locale ?? SiteLocale::resolve(request()));

        if (!$this->relationLoaded('translations')) {
            $this->loadMissing('translations');
        }

        return $this->translations->firstWhere('locale', $locale);
    }

    public function getRouteTextUrl(?string $locale = null): string
    {
        $translation = $this->translation($locale);

        return (string) ($translation?->text_url ?: $this->text_url);
    }

    public function getLocalizedValue(string $field, ?string $locale = null)
    {
        $translation = $this->translation($locale);

        if ($translation) {
            $translatedValue = $translation->{$field} ?? null;
            if ($translatedValue !== null && $translatedValue !== '') {
                return $translatedValue;
            }
        }

        return $this->{$field};
    }

    public function applyLocale(?string $locale = null): self
    {
        $locale = SiteLocale::normalize($locale ?? SiteLocale::resolve(request()));

        if ($locale === SiteLocale::RU) {
            $this->setAttribute('localized_text_url', $this->text_url);
            return $this;
        }

        foreach ([
            'title',
            'seo_description',
            'html_title',
            'first_paragraph',
            'content',
            'main_image_path',
            'hero_image_path',
            'article_layout',
        ] as $field) {
            $this->setAttribute($field, $this->getLocalizedValue($field, $locale));
        }

        $this->setAttribute('localized_text_url', $this->getRouteTextUrl($locale));

        return $this;
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

    public function feedbackAnswers()
    {
        return $this->hasMany(ArticleFeedbackAnswer::class);
    }

    public function tweetHrefGenerate()
    {
        $locale = SiteLocale::resolve(request());
        $routeName = SiteLocale::routeNameForLocale('blog.show_article', $locale);
        $url = route($routeName, $this->getRouteTextUrl($locale));
        $text = $this->getLocalizedValue('title', $locale);

        // Используем twitter.com, чтобы iOS-клиент открывал окно публикации, а не ленту
        return "https://twitter.com/intent/tweet?url=" . urlencode($url) . "&text=" . urlencode($text);
    }

    public function telegramHrefGenerate()
    {
        $locale = SiteLocale::resolve(request());
        $routeName = SiteLocale::routeNameForLocale('blog.show_article', $locale);
        $url = route($routeName, $this->getRouteTextUrl($locale));
        $text = $this->getLocalizedValue('title', $locale);

        // rawurlencode сохраняет пробелы как %20, чтобы Telegram не заменял их на +
        return "https://t.me/share/url?url=" . urlencode($url) . "&text=" . rawurlencode($text);
    }

    public function isMainImageZoomEnabled(): bool
    {
        // По умолчанию сохраняем текущее поведение (zoom), чтобы старые статьи не поменялись неожиданно
        return ($this->main_image_mode ?? 'zoom') === 'zoom';
    }

    public function getArticleLayout(): string
    {
        $layout = (string) ($this->article_layout ?? self::LAYOUT_CLASSIC);

        if (in_array($layout, [self::LAYOUT_CLASSIC, self::LAYOUT_IMAGE_HEADER, self::LAYOUT_PARALLAX], true)) {
            return $layout;
        }

        return self::LAYOUT_CLASSIC;
    }

    public function getHeroImagePath(): string
    {
        $heroImagePath = (string) ($this->hero_image_path ?? '');
        if ($heroImagePath !== '') {
            return $heroImagePath;
        }

        return (string) ($this->main_image_path ?? '');
    }

    public function getPreviewImagePath(): string
    {
        if (in_array($this->getArticleLayout(), [self::LAYOUT_IMAGE_HEADER, self::LAYOUT_PARALLAX], true)) {
            return $this->getHeroImagePath();
        }

        return (string) ($this->main_image_path ?? '');
    }

    // ВАЖНО (бизнес-логика):
    // main_image_mode управляет ТОЛЬКО кликабельностью главного изображения статьи.
    // Изображения внутри контента увеличиваются ТОЛЬКО если автор явно обернул <img> в <a data-fancybox="...">.

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

    public static function getRandomArticles($article_id, $quantity = 2, $since = null)
    {
        // Оптимизированная версия: используем inRandomOrder() вместо загрузки всех статей
        $query = Article::with(['user', 'blog_section', 'translations'])
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', 'article')
            ->where('id', '!=', $article_id)
            ->inRandomOrder();

        if ($since) {
            $query->where('created_at', '>=', $since);
        }

        return $query->limit($quantity)->get();
    }

    public function isMobile()
    {
        $agent = new Agent();
        return $agent->isMobile();
    }
}
