<?php

namespace App\Http\Controllers;

use App\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class StaticController extends Controller
{
    public function about_me()
    {
        $active_menu_item = 'Обо мне';
        return view('static_pages.about_me', compact('active_menu_item'));
    }
}
