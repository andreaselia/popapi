<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function handle(Request $request, $collection, $number)
    {
        $data = Data::with(['collection' => function ($query) use ($collection) {
            $query->where('slug', $collection);
        }])->where('number', $number)->first();

        if (! $data) {
            return Response::json([
                'response' => 'error'
            ]);
        }

        if (! $data['collection']) {
            return Response::json([
                'response' => 'error'
            ]);
        }

        return Response::json([
            'response' => 'success',
            'data' => $data
        ]);
    }
}
