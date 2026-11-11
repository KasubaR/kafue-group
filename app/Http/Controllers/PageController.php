<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function products(): View
    {
        return view('products');
    }

    public function services(): View
    {
        return view('services');
    }

    public function about(): View
    {
        return view('about');
    }

    public function contact(): View
    {
        return view('contact', [
            'categories' => QuoteController::CATEGORIES,
        ]);
    }
}
