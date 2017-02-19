<?php

namespace App\Http\Controllers;

use App\Result;
use App\Collection;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * [collections description]
     *
     * @param  Request $request
     * @param  string  $collection
     * @return [type]
     */
    public function collections(Request $request, $collection)
    {
        $data = Collection::where('slug', $collection)
            ->paginate(10);

        if ($data) {
            return response()->json([
                'response' => 'success',
                'data' => $data
            ]);
        }

        return response()->json([
            'response' => 'error'
        ]);
    }

    /**
     * [results description]
     *
     * @param  Request $request
     * @param  string  $collection
     * @param  integer  $number
     * @return [type]
     */
    public function results(Request $request, $collection, $number)
    {
        $data = Result::with(['collection' => function ($query) use ($collection) {
            $query->where('slug', $collection);
        }])->where('number', $number)->first();

        if ($data) {
            return response()->json([
                'response' => 'success',
                'data' => $data
            ]);
        }

        return response()->json([
            'response' => 'error'
        ]);
    }
}
