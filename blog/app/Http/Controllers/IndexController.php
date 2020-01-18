<?php

namespace App\Http\Controllers;

use App\Article;

class IndexController extends Controller
{
    /**
     * Show the main page.
     *
     * @param int $id
     * @return View
     */
    public function show()
    {
        $last_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
            "article")->limit(3)->get();
        return view('index', compact('last_articles'));
    }
}