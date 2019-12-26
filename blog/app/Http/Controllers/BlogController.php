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
        return view('blog.index_sidebar', compact('articles'));
    }

    public function show_article($article_id)
    {

        $article = Article::findOrFail($article_id);
        $article->views_update();
        $commentsHtml = Comment::getAllCommentsHtml($article);

        return view('blog.article', compact('article', 'commentsHtml'));

    }

    public function show_old()
    {
        return view('blog.index_sidebar');
    }

    public function add_comment(CommentRequest $request)
    {
        if ($comment = Comment::createComment($request)) {
            return redirect(route('blog.show_article', $request->article_id) . "#comment_" . $comment->id);
        }

    }
}