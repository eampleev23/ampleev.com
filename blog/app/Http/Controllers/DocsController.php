<?php

namespace App\Http\Controllers;

use App\Article;
use App\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class DocsController extends Controller
{

    public function show_doc()
    {
        return view('blog.index_masonry');
    }

    public function show_terms_of_use()
    {
        $last_articles = Article::orderBy('views_count', 'desc')->where('type_article', '=',
            "article")->limit(2)->get();
        $active_menu_item = 'Правила';
        return view('docs.terms_of_use', compact('last_articles', 'active_menu_item'));
    }
}
