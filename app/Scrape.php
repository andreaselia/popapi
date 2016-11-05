<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scrape extends Model
{
    public function __construct()
    {
        return getenv('FUNKO_URL');
    }

    /**
     * @param  string $collection
     */
    public function funko($collection)
    {
        // $crawler = Goutte::request('GET', env('FUNKO_POP_URL', 'single').'/'.$collection);

        $crawler = Goutte::request('GET', 'https://funko.com/collections/pop-vinyl/disney');

        $crawler->filter('footer .pagination')->each(function ($node) {
            $page_count = $node->filter('li:nth-last-child(2)')->text();

            $collection = Collection::firstOrCreate([
                'slug' => 'disney',
                'name' => 'Disney'
            ]);

            for ($i = 0; $i < $page_count + 1; $i++) {
                $newler = Goutte::request('GET', 'https://funko.com/collections/pop-vinyl/disney?page='.$i);

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
