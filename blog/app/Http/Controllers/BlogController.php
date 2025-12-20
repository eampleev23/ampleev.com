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
        $articles = Article::with(['user', 'blog_section'])
            ->orderBy('created_at', 'desc')
            ->where('type_article', '=', 'article')
            ->where('confirmed', '=', '1')
            ->get();

        $items = Article::with(['user', 'blog_section'])
            ->orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->get();

        $top_articles = Article::with(['user', 'blog_section'])
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

        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        $active_menu_item = 'Блог';

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

        $random_link = Article::getRandomLink();
        $random_articles = Article::getRandomArticles($article->id, 2);

        $active_menu_item = 'Блог_статья';

        return view('blog.article',
            compact('article', 'commentsHtml', 'last_articles', 'random_link', 'random_articles', 'active_menu_item'));
    }

    public function show_blog_section($blog_section_name)
    {
        $blog_section = BlogSection::where('title', '=', $blog_section_name)->firstOrFail();

        $articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('blog_section_id', '=', $blog_section->id)
            ->get();

        $items = $articles;

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

        $random_link = Article::getRandomLink();
        $random_articles = Article::getRandomArticles(1, 2);

        $active_menu_item = 'Блог_статья';

        return view('blog.article_layout',
            compact('article', 'last_articles', 'random_link', 'random_articles', 'active_menu_item'));
    }

    public function show_old()
    {
        return view('blog.index_sidebar');
    }

    public function add_comment(CommentRequest $request)
    {
        if ($comment = Comment::createComment($request)) {
            return redirect(route('blog.show_article', $request->article_text_url) . "#comment_" . $comment->id);
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
            return redirect(route('blog.home'))->with('error', 'Неверная ссылка для отписки.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect(route('blog.home'))->with('error', 'Пользователь не найден.');
        }

        // Проверяем токен
        $expectedToken = md5($user->email . $user->id . config('app.key'));
        if ($token !== $expectedToken) {
            return redirect(route('blog.home'))->with('error', 'Неверная ссылка для отписки.');
        }

        // Отключаем уведомления
        $user->comment_notifications_enabled = false;
        $user->save();

        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('created_at', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        $active_menu_item = '';

        return view('utility.unsubscribed_comment_notifications', compact('user', 'last_articles', 'active_menu_item'));
    }
}
