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

    public function show_article_test()
    {
//        $test = Storage::get('/public/user_avatars/female-3_my.jpg');
//        $test = Storage::disk('local')->exists('public/user_avatars/female-3_my.jpg');
        $test = Storage::url('public/user_avatars/female-3_my.jpg');
        dd($test);
//        Storage::disk('local')->put('file.txt', 'Contents');
//        echo asset('storage/file.txt');
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