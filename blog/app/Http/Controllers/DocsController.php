<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function show_terms_of_use()
    {
        return view('docs.terms_of_use');
    }
}
