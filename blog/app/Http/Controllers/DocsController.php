<?php

namespace App\Http\Controllers;

use App\Article;
use App\Layout;
use App\Support\SiteLocale;
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

        $active_menu_item = 'Правила';
        return view('docs.terms_of_use', compact('active_menu_item'));
    }
}
