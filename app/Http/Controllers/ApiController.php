<?php

namespace App\Http\Controllers;

use App\Result;
use App\Collection;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function collections(Request $request)
    {
        $data = Collection::all();

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

    public function collection(Request $request, $collection, $page = 1)
    {
        $data = Collection::where('slug', $collection)
            ->with(['results' => function ($query) use ($page) {
                $query->offset(($page - 1) * 10)->take(10);
            }])
            ->get();

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

    public function results(Request $request)
    {
        $data = Result::all();

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

    public function result(Request $request, $collection, $sku, $page = 1)
    {
        $data = Result::with(['collection' => function ($query) use ($collection) {
            $query->where('slug', $collection);
        }])->where('sku', $sku)->first();

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
