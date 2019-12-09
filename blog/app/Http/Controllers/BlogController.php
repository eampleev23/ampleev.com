<?php

namespace App\Http\Controllers;

use App\Article;

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
        return view('blog.index_masonry');
    }

    public function show_article_test()
    {
        return view('blog.article_test');
    }

    public function show_article($article_id)
    {

        $article = Article::findOrFail($article_id);
        return view('blog.article', compact('article'));

    }

    public function show_old()
    {
        return view('blog.index_sidebar');
    }
}