<?php

namespace App\Http\Controllers;

class TestController extends Controller
{

    public function show_nav()
    {
        return view('test.navigation');
    }

    public function show_modals()
    {
        return view('test.modals');
    }

    public function show_article_test()
    {
        return view('blog.article_test');
    }
}