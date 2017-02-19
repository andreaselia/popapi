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
        $stats = [
            'collections'  => \App\Collection::count(),
            'results'      => \App\Result::count(),
            'combinations' => 'N/A',
        ];

        return view('documentation.index')->with(compact('stats'));
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
