<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function documentation()
    {
        return view('documentation.index');
    }

    public function documentationPage($page)
    {
        return view('documentation.'.$page);
    }
}
