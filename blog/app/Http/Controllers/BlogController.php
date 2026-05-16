<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleFeedbackAnswer;
use App\BlogSection;
use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Layout;
use App\Mailing;
use App\ArticleTranslation;
use App\Http\Requests\MailingRequest;
use App\Support\SiteLocale;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class BlogController extends Controller
{
    private function currentLocale(): string
    {
        return SiteLocale::resolve(request());
    }

    private function localeLabels(?string $locale = null): array
    {
        return SiteLocale::labels($locale ?? $this->currentLocale());
    }

    private function localizeArticles($articles, ?string $locale = null)
    {
        $locale = $locale ?? $this->currentLocale();

        if ($articles instanceof \Illuminate\Support\Collection || $articles instanceof \Illuminate\Contracts\Pagination\Paginator) {
            $articles->each(function ($article) use ($locale) {
                if ($article instanceof Article) {
                    $article->applyLocale($locale);
                }
            });
        }

        return $articles;
    }

    /**
     * Show the main page.
     *
     * @param int $id
     * @return View
     */
    public function show()
    {
        $locale = $this->currentLocale();

        // Получаем все подтвержденные статьи (без ссылок) в порядке от новых к старым
        $allArticles = Article::with(['user', 'blog_section', 'translations'])
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', 'article')
            ->orderBy('created_at', 'desc')
            ->get();
        $this->localizeArticles($allArticles, $locale);

        // Сохраняем совместимость с текущими шаблонами, но без группировки по годам
        $groupedArticles = [[
            'title' => '',
            'articles' => $allArticles,
        ]];
        $items = $allArticles;
        $articles = $allArticles;
        $hasEnglishFallbackContent = $locale === SiteLocale::EN
            && $allArticles->contains(function ($article) {
                return !$article->translation(SiteLocale::EN);
            });

        $top_articles = Article::with(['user', 'blog_section', 'translations'])
            ->whereHas('viewsArticles', function($query) {
                $query->where('created_at', '>=', now()->subWeeks(2));
            })
            ->withCount(['viewsArticles as recent_views_count' => function($query) {
                $query->where('created_at', '>=', now()->subWeeks(2));
            }])
            ->where('confirmed', 1)
            ->where('type_article', 'article')
            ->orderBy('recent_views_count', 'desc')
            ->limit(10)
            ->get();
        $this->localizeArticles($top_articles, $locale);

        $last_articles = Article::with(['user', 'blog_section', 'translations'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();
        $this->localizeArticles($last_articles, $locale);

        $active_menu_item = 'Блог';

        $layout = config('blog.index_layout', 'classic');
        if ($layout === 'masonry') {
            return view('blog.index_masonry_dynamic',
                compact('articles', 'top_articles', 'last_articles', 'items', 'active_menu_item', 'groupedArticles', 'hasEnglishFallbackContent'));
        }

        return view('blog.index_sidebar',
            compact('articles', 'top_articles', 'last_articles', 'items', 'active_menu_item', 'groupedArticles', 'hasEnglishFallbackContent'));
    }

    public function show_article($article_text_url)
    {
        $locale = $this->currentLocale();

        $article = Article::with(['user', 'blog_section', 'translations'])
            ->withCount('comments')
            ->where(function ($query) use ($article_text_url, $locale) {
                $query->where('text_url', '=', $article_text_url);

                if ($locale === SiteLocale::EN) {
                    $query->orWhereHas('translations', function ($translationQuery) use ($article_text_url) {
                        $translationQuery->where('locale', SiteLocale::EN)
                            ->where('text_url', $article_text_url);
                    });
                }
            })
            ->where('confirmed', '=', '1')
            ->firstOrFail();
        $article->applyLocale($locale);

        $article->views_update();
        $feedbackQuery = ArticleFeedbackAnswer::where('article_id', $article->id);

        if (Auth::check()) {
            $feedbackQuery->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhere(function ($ipQuery) {
                        $ipQuery->where('ip', request()->ip())
                            ->whereNull('user_id');
                    });
            });
        } else {
            $feedbackQuery->where('ip', request()->ip());
        }

        $articleFeedbackAnswers = $feedbackQuery->pluck('answer', 'question_key');
        $commentsHtml = Comment::getAllCommentsHtml($article);

        $last_articles = Article::with(['user', 'blog_section', 'translations'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();
        $this->localizeArticles($last_articles, $locale);

        $random_articles = Article::getRandomArticles($article->id, 3, null);
        $this->localizeArticles($random_articles, $locale);

        $active_menu_item = 'Блог_статья';
        $cursorExperienceArticle = Article::with(['user', 'blog_section', 'translations'])
            ->where('text_url', '=', 'moy_opyt_ispolzovaniya_cursor')
            ->where('type_article', '=', 'article')
            ->first();
        if ($cursorExperienceArticle) {
            $cursorExperienceArticle->applyLocale($locale);
        }

        return view('blog.article',
            compact('article', 'commentsHtml', 'last_articles', 'random_articles', 'active_menu_item', 'cursorExperienceArticle', 'articleFeedbackAnswers'));
    }

    public function show_blog_section($blog_section_name)
    {
        $locale = $this->currentLocale();

        // Декодируем URL-кодированное название раздела (для поддержки слэшей и других спецсимволов)
        // Также заменяем подчеркивания обратно на слэши (если использовали замену)
        $blog_section_name = str_replace('_SLASH_', '/', urldecode($blog_section_name));
        $blog_section = BlogSection::where('title', '=', $blog_section_name)->firstOrFail();

        $items = Article::with(['user', 'blog_section', 'translations'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', 'article')
            ->where('blog_section_id', '=', $blog_section->id)
            ->paginate(config('blog.per_page', 10));
        $this->localizeArticles($items->getCollection(), $locale);
        $hasEnglishFallbackContent = $locale === SiteLocale::EN
            && $items->getCollection()->contains(function ($article) {
                return !$article->translation(SiteLocale::EN);
            });

        // Для совместимости со старым шаблоном
        $articles = $items;

        $top_articles = Article::with(['user', 'blog_section', 'translations'])
            ->orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(4)
            ->get();
        $this->localizeArticles($top_articles, $locale);

        $last_articles = Article::with(['user', 'blog_section', 'translations'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();
        $this->localizeArticles($last_articles, $locale);

        $active_menu_item = 'Блог';

        $layout = config('blog.index_layout', 'classic');
        if ($layout === 'masonry') {
            return view('blog.index_masonry_blog_section',
                compact('articles', 'top_articles', 'last_articles', 'items', 'active_menu_item', 'blog_section', 'hasEnglishFallbackContent'));
        }

        return view('blog.index_sidebar_blog_section',
            compact('articles', 'top_articles', 'last_articles', 'items', 'active_menu_item', 'blog_section', 'hasEnglishFallbackContent'));
    }

    public function show_article_layout()
    {
        $article = Article::where('text_url', '=', 'praktika_primenenia_burn_down_charts_v_kontekste_safe_i_scrum')
            ->where('confirmed', '=', '1')
            ->firstOrFail();

        $last_articles = Article::orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        $random_articles = Article::getRandomArticles(1, 3, null);

        $active_menu_item = 'Блог_статья';

        return view('blog.article_layout',
            compact('article', 'last_articles', 'random_articles', 'active_menu_item'));
    }

    public function show_old()
    {
        return view('blog.index_sidebar');
    }

    public function add_comment(CommentRequest $request)
    {
        $labels = $this->localeLabels(SiteLocale::resolve($request));

        try {
            \Log::info('add_comment called', [
                'user_id' => Auth::id(),
                'article_id' => $request->article_id,
                'content_length' => strlen($request->content ?? ''),
            ]);
            
            $comment = Comment::createComment($request);
            
            if ($comment) {
                \Log::info('Comment created successfully in controller', ['comment_id' => $comment->id]);
                return redirect(route('blog.show_article', $request->article_text_url) . "#comment_" . $comment->id)
                    ->with('success', $labels['comment_added_success'] ?? 'Комментарий успешно добавлен!');
            }
            
            // Если createComment вернул false
            \Log::error('createComment returned false', [
                'user_id' => Auth::id(),
                'article_id' => $request->article_id,
            ]);
            
            return redirect(route('blog.show_article', $request->article_text_url) . '#add_comment')
                ->with('error', $labels['comment_save_failed'] ?? 'Не удалось сохранить комментарий. Попробуйте еще раз.')
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Exception in add_comment', [
                'user_id' => Auth::id(),
                'article_id' => $request->article_id ?? null,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect(route('blog.show_article', $request->article_text_url) . '#add_comment')
                ->with('error', ($labels['comment_save_error'] ?? 'Произошла ошибка при сохранении комментария: ') . ' ' . $e->getMessage())
                ->withInput();
        }
    }

    public function add_subscriber(MailingRequest $request)
    {
        if ($subscriber = Mailing::createSubscriber($request)) {
            $utilityRoute = SiteLocale::routeNameForLocale(
                'utility.confirm_subscriber',
                SiteLocale::resolve($request)
            );

            return redirect(route($utilityRoute, $subscriber->email));
        }
    }

    public function confirm_subscriber($email)
    {
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        $active_menu_item = '';

        return view('utility.confirmation_mailing_lists', compact('email', 'last_articles', 'active_menu_item'));
    }

    public function confirmed_subscriber($hash)
    {
        if ($subscriber = Mailing::where([
            ['url', '=', $hash],
            ['confirmed', '=', 0],
        ])->firstOrFail()) {
            $subscriber->confirmed = 1;
            if ($subscriber->save()) {
                $subscriber->send_the_final_confirmation();
            }

            $last_articles = Article::with(['user', 'blog_section'])
                ->orderBy('created_at', 'desc')
                ->where('confirmed', '=', '1')
                ->where('type_article', '=', "article")
                ->limit(2)
                ->get();

            $active_menu_item = '';

            return view('utility.confirmed_mailing_lists', compact('subscriber', 'last_articles', 'active_menu_item'));
        }
    }

    public function sitemap()
    {
        $articles = Article::orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', 'article')
            ->get();

        return view('blog.sitemap')->with(compact('articles'));
    }

    public function unsubscribe_comment_notifications()
    {
        $labels = $this->localeLabels();
        $email = request('email');
        $token = request('token');

        if (!$email || !$token) {
            return redirect(route('static_pages.home'))->with('error', $labels['unsubscribe_invalid_link'] ?? 'Неверная ссылка для отписки.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect(route('static_pages.home'))->with('error', 'Пользователь не найден.');
        }

        // Проверяем токен (используем hash_hmac для безопасности)
        $expectedToken = hash_hmac('sha256', $user->email . $user->id, config('app.key'));
        if (!hash_equals($expectedToken, $token)) {
            return redirect(route('static_pages.home'))->with('error', 'Неверная ссылка для отписки.');
        }

        // Отключаем уведомления
        $user->comment_notifications_enabled = false;
        if ($user->save()) {
            \Log::info('Comment notifications disabled for user', [
                'user_id' => $user->id,
                'email' => $user->email,
                'comment_notifications_enabled' => $user->comment_notifications_enabled
            ]);
        } else {
            \Log::error('Failed to disable comment notifications for user', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        }

        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        $active_menu_item = '';

        return view('utility.unsubscribed_comment_notifications', compact('user', 'last_articles', 'active_menu_item'));
    }

    public function unsubscribe_mailing($hash)
    {
        $subscriber = Mailing::where('url', $hash)->first();

        if (!$subscriber) {
            return redirect(route('static_pages.home'))->with('error', 'Подписка не найдена.');
        }

        // Удаляем подписку
        $email = $subscriber->email;
        $subscriber->delete();

        \Log::info('Mailing subscription removed', [
            'email' => $email,
            'hash' => $hash
        ]);

        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        $active_menu_item = '';

        return view('utility.unsubscribed_mailing', compact('email', 'last_articles', 'active_menu_item'));
    }
}
