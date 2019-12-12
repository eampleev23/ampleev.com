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
}