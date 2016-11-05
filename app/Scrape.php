<?php

namespace App;

use Goutte;
use Illuminate\Database\Eloquent\Model;

class Scrape extends Model
{
    /**
     * @param  string $collection
     */
    public static function funko($collection)
    {
        // Send the initial request to the specified collection web page
        $crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection);

        //
        $pages = $crawler->filter('footer .pagination li:nth-last-child(2)')->text();

        for ($i = 0; $i < $pages + 1; $i++) {
            $newler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection.'?page='.$i);

            $newler->filter('.product-item')->each(function ($node) use ($collection) {
                $url   = str_replace('//cdn', 'http://cdn', $node->filter('img')->attr('src'));
                $file  = file_get_contents($url);
                $name  = explode('?v=', basename($url))[0];
                $sku   = explode('#', $node->filter('.product-sku')->text())[1];
                $title = trim($node->filter('.title a')->text());

                if (! is_dir($collection)) {
                    mkdir($collection);
                }

                if (isset($sku) && is_numeric($sku)) {
                    file_put_contents($collection.'/'.$sku.'.jpg', $file);
                } else {
                    file_put_contents($collection.'/'.time().'_VAULTED.jpg', $file);
                }
            });
        }

        return true;
    }
}
