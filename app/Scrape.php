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
        $crawler = Goutte::request('GET', env('FUNKO_POP_URL', 'single').'/'.$collection);

        //
    }
}
