<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Пока один продукт - редирект на pointscounter.ampleev.com
     * В будущем здесь будет разводящая страница с несколькими продуктами
     */
    public function index()
    {
        return redirect('https://pointscounter.ampleev.com', 301);
    }
}

