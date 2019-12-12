<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    /**
     * Show the main page.
     *
     * @param int $id
     * @return View
     */
    public function show()
    {
        dd(md5('123'));
    }
}