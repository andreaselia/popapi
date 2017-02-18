<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * [index description]
     *
     * @return [type]
     */
    public function index()
    {
        return view('home');
    }

    /**
     * [documentation description]
     *
     * @return [type]
     */
    public function documentation()
    {
        return view('documentation.index');
    }

    /**
     * [documentationPage description]
     *
     * @param  string $page
     * @return [type]
     */
    public function documentationPage($page)
    {
        return view('documentation.'.$page);
    }
}
