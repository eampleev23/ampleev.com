<?php

namespace App\Http\Controllers;

use App\Article;
use App\BlogSection;
use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Layout;
use App\Mailing;
use App\Http\Requests\MailingRequest;
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
//        echo phpinfo();die();
//        $articles = Article::orderBy('created_at', 'desc')->where('type_article', '=', 'article')->get();
        $articles = Article::orderBy('views_count', 'desc')->where(['type_article', '=', 'article'])->get();
//        $items = Article::orderBy('created_at', 'desc')->get();
        $items = Article::orderBy('views_count', 'desc')->get();
        $top_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
            "article")->limit(4)->get();
        $last_articles = Article::orderBy('views_count', 'desc')->where('type_article', '=',
            "article")->limit(2)->get();
        $active_menu_item = 'Блог';
        return view('blog.index_sidebar',
            compact('articles', 'top_articles', 'last_articles', 'items', 'request', 'active_menu_item'));
    }

    public function show_article($article_text_url)
    {
        $article = Article::where('text_url', '=', $article_text_url)->firstOrFail();
        $article->views_update();
        $commentsHtml = Comment::getAllCommentsHtml($article);
        $last_articles = Article::orderBy('views_count', 'desc')->where('type_article', '=',
            "article")->limit(2)->get();
        $random_link = Article::getRandomLink();
        $random_articles = Article::getRandomArticles(2, $article->id);
        $active_menu_item = 'Блог_статья';
        return view('blog.article',
            compact('article', 'commentsHtml', 'last_articles', 'random_link', 'random_articles', 'active_menu_item'));
    }

    public function show_blog_section($blog_section_name)
    {
        $blog_section = BlogSection::where('title', '=', $blog_section_name)->firstOrFail();
        $articles = Article::orderBy('views_count', 'desc')->where('blog_section_id', '=', $blog_section->id)->get();
        $items = $articles;
        $top_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
            "article")->limit(4)->get();
        $last_articles = Article::orderBy('views_count', 'desc')->where('type_article', '=',
            "article")->limit(2)->get();
        $active_menu_item = 'Блог';
        return view('blog.index_sidebar_blog_section',
            compact('articles', 'top_articles', 'last_articles', 'items', 'request', 'active_menu_item', 'blog_section'));
    }

    public function show_article_layout()
    {
        $article = Article::where('text_url', '=',
            'praktika_primenenia_burn_down_charts_v_kontekste_safe_i_scrum')->firstOrFail();
        $last_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
            "article")->limit(2)->get();
        $random_link = Article::getRandomLink();
        $random_articles = Article::getRandomArticles(2, 1);
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

        $last_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
            "article")->limit(2)->get();
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
            $last_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
                "article")->limit(2)->get();
            $active_menu_item = '';
            return view('utility.confirmed_mailing_lists', compact('subscriber', 'last_articles', 'active_menu_item'));
        }
    }

    public function sitemap()
    {
        $articles = Article::orderBy('created_at', 'desc')->where('type_article', '=', 'article')->get();
        return view('blog.sitemap')->with(compact('articles'));
    }
}