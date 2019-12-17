<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Support\Facades\Storage;

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

    public function show_article($article_id)
    {

        $article = Article::findOrFail($article_id);
        $article->views_update();
        return view('blog.article', compact('article'));

    }

    public function show_old()
    {
        return view('blog.index_sidebar');
    }
}