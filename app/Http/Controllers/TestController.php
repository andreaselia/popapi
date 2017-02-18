<?php

namespace App\Http\Controllers;

use Storage;
use Validator;
use App\Scrape;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * [index description]
     *
     * @return [type]
     */
    public function index()
    {
        $contents = Storage::disk('s3')->listContents();

        foreach ($contents as $key => $content) {
            if ($content['type'] == 'dir') {
                $contents[$key]['data'] = Storage::disk('s3')->listContents($content['path']);
            }
        }

        return view('test')->with(compact('contents'));
    }

    /**
     * [scrape description]
     *
     * @param  string $collection
     * @return [type]
     */
    public function scrape($collection)
    {
        $start = Carbon::now();

        Scrape::funko($collection);

        $end = Carbon::now();

        return sprintf(
            'Scraped <strong>%s</strong> in <strong>%s seconds</strong>',
            $collection,
            $end->diffInSeconds($start)
        );
    }
}
