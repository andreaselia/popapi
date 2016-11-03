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

    public function scrape($collection)
    {
        $client = new Client();

        $crawler = $client->request('GET', 'https://funko.com/collections/pop-vinyl/disney');

        $crawler->filter('footer .pagination')->each(function ($node) {
            $page_count = $node->filter('li:nth-last-child(2)')->text();
            $client     = new Client();

            $collection = Collection::firstOrCreate([
                'slug' => 'disney',
                'name' => 'Disney'
            ]);

            for ($i = 0; $i < $page_count + 1; $i++) {
                $newler = $client->request('GET', 'https://funko.com/collections/pop-vinyl/disney?page='.$i);

                $newler->filter('.product-item')->each(function ($node) {
                    $collection = Collection::where('slug', 'disney')->first();

                    $url  = str_replace('//cdn', 'http://cdn', $node->filter('img')->attr('src'));
                    $file = file_get_contents($url);
                    $name = explode('?v=', basename($url))[0];
                    $sku  = explode('#', $node->filter('.product-sku')->text())[1];

                    if (! is_dir('disney')) {
                        mkdir('disney');
                    }

                    $save = file_put_contents('disney/'.$name, $file);

                    $data = Data::create([
                        'collection_id' => $collection->id,
                        'number'        => (isset($sku) && is_numeric($sku)) ? $sku : 0,
                        'image'         => $name,
                        'shop'          => NULL,
                        'average_value' => 0,
                    ]);
                });
            }
        });
    }
}
