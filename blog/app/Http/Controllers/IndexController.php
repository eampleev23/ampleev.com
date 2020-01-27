<?php

namespace App\Http\Controllers;

use App\Article;
use App\Layout;
use Illuminate\Support\Facades\URL;

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
        $active_menu_item = Layout::get_active_menu_item(URL::current());
        return view('index', compact('last_articles', 'active_menu_item'));
    }
}