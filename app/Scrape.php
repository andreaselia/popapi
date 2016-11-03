<?php

namespace App;

use Goutte\Client;
use Illuminate\Database\Eloquent\Model;

class Scrape extends Model
{
    /**
     * @var Client
     */
    protected $goutteClient;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->goutteClient = $client;
        $this->baseUrl = getenv('FUNKO_URL');
    }

    /**
     * @param  string $collection
     */
    public function funko($collection)
    {
        //
    }
}
