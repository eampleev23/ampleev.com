<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Article;
use App\Support\SiteLocale;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }

    /**
     * Show the current user's profile page.
     *
     * @return View
     */
    public function profile()
    {
        $user = Auth::user();
        $active_menu_item = 'Мой профиль';
        $locale = SiteLocale::resolve(request());
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        if ($locale === SiteLocale::EN) {
            $last_articles->each->applyLocale(SiteLocale::EN);
        }
        
        return view('user.my_profile', compact('user', 'active_menu_item', 'last_articles', 'locale'));
    }
}
