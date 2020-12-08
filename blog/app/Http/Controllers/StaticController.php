<?php

namespace App\Http\Controllers;

use App\Article;
use App\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class StaticController extends Controller
{
    public function about_me()
    {
        $active_menu_item = 'Обо мне';
        $last_articles = Article::orderBy('views_count', 'desc')->where('confirmed',
            '=', '1')->where('type_article', '=',
            "article")->limit(2)->get();
        return view('static_pages.about_me', compact('active_menu_item', 'last_articles'));
    }
}
