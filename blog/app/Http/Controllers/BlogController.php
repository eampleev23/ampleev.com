<?php

namespace App\Http\Controllers;

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

    public function show_article()
    {
        return view('blog.article');
    }

    public function show_old()
    {
        return view('blog.index_sidebar');
    }
}