<?php

namespace App\Http\Controllers;

class EconomySimController extends Controller
{
    public function show()
    {
        $active_menu_item = null;

        return view('apps.economy_sim', compact('active_menu_item'));
    }
}
