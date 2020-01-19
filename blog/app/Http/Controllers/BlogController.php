<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Http\Requests\CommentRequest;

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
        $articles = Article::orderBy('created_at', 'desc')->where('type_article', '=', 'article')->get();
        $items = Article::orderBy('created_at', 'desc')->get();
        $top_articles = Article::orderBy('views_count', 'desc')->where('type_article', '=',
            "article")->limit(3)->get();
        $last_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
            "article")->limit(3)->get();
        return view('blog.index_sidebar', compact('articles', 'top_articles', 'last_articles', 'items'));
    }

    public function show_article($article_text_url)
    {
        $article = Article::where('text_url', '=', $article_text_url)->firstOrFail();
        $article->views_update();
        $commentsHtml = Comment::getAllCommentsHtml($article);
        $last_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
            "article")->limit(3)->get();
        $random_link = Article::getRandomLink();
        $random_articles = Article::getRandomArticles(2, $article->id);
        return view('blog.article',
            compact('article', 'commentsHtml', 'last_articles', 'random_link', 'random_articles'));
    }

    public function show_old()
    {
        return view('blog.index_sidebar');
    }

    public function add_comment(CommentRequest $request)
    {
        dd('here');
        if ($comment = Comment::createComment($request)) {
            return redirect(route('blog.show_article', $request->article_text_url) . "#comment_" . $comment->id);
        }

    }
}