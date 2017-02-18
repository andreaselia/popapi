<?php

namespace App\Http\Controllers;

use App\Result;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * [handle description]
     *
     * @param  Request $request
     * @param  string  $collection
     * @param  integer  $number
     * @return [type]
     */
    public function handle(Request $request, $collection, $number)
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
