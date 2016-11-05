<?php

namespace App\Http\Controllers;

use Storage;
use Validator;
use App\Scrape;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $contents = Storage::disk('s3')->listContents();

        return view('test')
            ->with(compact('contents'));
    }

    /**
     * @param  Request $request
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'document' => 'required|image',
        ]);

        $file = $request->file('document');

        $exists = Storage::disk('s3')
            ->exists($file->getClientOriginalName());

        if (! $exists) {
            $s3 = Storage::disk('s3')
                ->put($file->getClientOriginalName(), file_get_contents($file), 'public');
        }

        return 'file already exists';
    }

    /**
     * @param  string $collection
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
