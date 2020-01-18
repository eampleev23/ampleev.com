<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class DocsController extends Controller
{

    public function show_doc()
    {
        return view('blog.index_masonry');
    }

    public function show_terms_of_use()
    {
        $last_articles = Article::orderBy('created_at', 'desc')->where('type_article', '=',
            "article")->limit(3)->get();
        return view('docs.terms_of_use', compact('last_articles'));
    }
}
