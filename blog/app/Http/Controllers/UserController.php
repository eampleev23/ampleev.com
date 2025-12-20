<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
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
        
        return view('user.my_profile', compact('user', 'active_menu_item'));
    }
}