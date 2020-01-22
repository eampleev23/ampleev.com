<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function about_me()
    {
        return view('static_pages.about_me');
    }
}
