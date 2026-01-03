<?php

namespace App\Http\Controllers;

use App\Article;
use App\BlogSection;
use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Layout;
use App\Mailing;
use App\Http\Requests\MailingRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class BlogController extends Controller
{
    /**
     * Show the main page.
     *
     * @param int $id
     * @return View
     */
    public function show()
    {
        // На главной странице блога показываем только статьи за последний год.
        // Старые статьи остаются доступными по прямой ссылке (/article_{text_url}).
        $yearAgo = now()->subYear();

        $items = Article::with(['user', 'blog_section'])
            ->orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->whereIn('type_article', ['article', 'link'])
            ->where('created_at', '>=', $yearAgo)
            ->paginate(config('blog.per_page', 10));

        // Для совместимости со старым шаблоном (если где-то используется отдельно)
        $articles = $items;

        $top_articles = Article::with(['user', 'blog_section'])
            ->whereHas('viewsArticles', function($query) {
                $query->where('created_at', '>=', now()->subWeeks(2));
            })
            ->withCount(['viewsArticles as recent_views_count' => function($query) {
                $query->where('created_at', '>=', now()->subWeeks(2));
            }])
            ->where('confirmed', 1)
            ->where('type_article', 'article')
            ->where('created_at', '>=', $yearAgo)
            ->orderBy('recent_views_count', 'desc')
            ->limit(10)
            ->get();

        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->where('created_at', '>=', $yearAgo)
            ->limit(2)
            ->get();

        $active_menu_item = 'Блог';

        $layout = config('blog.index_layout', 'classic');
        if ($layout === 'masonry') {
            return view('blog.index_masonry_dynamic',
                compact('articles', 'top_articles', 'last_articles', 'items', 'active_menu_item'));
        }

        return view('blog.index_sidebar',
            compact('articles', 'top_articles', 'last_articles', 'items', 'active_menu_item'));
    }

    public function show_article($article_text_url)
    {
        $article = Article::with(['user', 'blog_section'])
            ->withCount('comments')
            ->where('text_url', '=', $article_text_url)
            ->where('confirmed', '=', '1')
            ->firstOrFail();

        $article->views_update();
        $commentsHtml = Comment::getAllCommentsHtml($article);

        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        $random_articles = Article::getRandomArticles($article->id, 3, now()->subYear());

        $active_menu_item = 'Блог_статья';

        return view('blog.article',
            compact('article', 'commentsHtml', 'last_articles', 'random_articles', 'active_menu_item'));
    }

    public function show_blog_section($blog_section_name)
    {
        // Декодируем URL-кодированное название раздела (для поддержки слэшей и других спецсимволов)
        // Также заменяем подчеркивания обратно на слэши (если использовали замену)
        $blog_section_name = str_replace('_SLASH_', '/', urldecode($blog_section_name));
        $blog_section = BlogSection::where('title', '=', $blog_section_name)->firstOrFail();

        $items = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', 'article')
            ->where('blog_section_id', '=', $blog_section->id)
            ->paginate(config('blog.per_page', 10));

        // Для совместимости со старым шаблоном
        $articles = $items;

        $top_articles = Article::with(['user', 'blog_section'])
            ->orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(4)
            ->get();

        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        $active_menu_item = 'Блог';

        $layout = config('blog.index_layout', 'classic');
        if ($layout === 'masonry') {
            return view('blog.index_masonry_blog_section',
                compact('articles', 'top_articles', 'last_articles', 'items', 'active_menu_item', 'blog_section'));
        }

        return view('blog.index_sidebar_blog_section',
            compact('articles', 'top_articles', 'last_articles', 'items', 'active_menu_item', 'blog_section'));
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

        $random_articles = Article::getRandomArticles(1, 3, now()->subYear());

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
                    ->with('success', 'Комментарий успешно добавлен!');
            }
            
            // Если createComment вернул false
            \Log::error('createComment returned false', [
                'user_id' => Auth::id(),
                'article_id' => $request->article_id,
            ]);
            
            return redirect(route('blog.show_article', $request->article_text_url) . '#add_comment')
                ->with('error', 'Не удалось сохранить комментарий. Попробуйте еще раз.')
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
                ->with('error', 'Произошла ошибка при сохранении комментария: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function add_subscriber(MailingRequest $request)
    {
        if ($subscriber = Mailing::createSubscriber($request)) {
            return redirect(route('utility.confirm_subscriber', $subscriber->email));
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
        $email = request('email');
        $token = request('token');

        if (!$email || !$token) {
            return redirect(route('static_pages.home'))->with('error', 'Неверная ссылка для отписки.');
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
