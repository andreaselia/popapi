<?php

namespace App\Console\Commands;

use Uuid;
use Goutte;
use Storage;
use Illuminate\Console\Command;

class ScrapeFunko extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:funko';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Funko POP! Vinyl Scraper';

    /**
     * The collections to be scraped.
     *
     * @var array
     */
    protected $collections = [
        'animation',
        'disney',
        'games',
        'heroes',
        'marvel',
        'monster-high',
        'movies',
        'pets',
        'rocks',
        'sports',
        'star-wars',
        'television',
        'the-vault',
        'the-vote',
        'ufc',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->collections as $collection) {
            $this->scrape($collection);
        }
    }

    /**
     * For scraping data for the specified collection.
     *
     * @param  string $collection
     * @return boolean
     */
    public static function scrape($collection)
    {
        $crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection);

        $pages = $crawler->filter('footer .pagination li')->count() > 0
            ? $crawler->filter('footer .pagination li:nth-last-child(2)')->text()
            : 0
        ;

        for ($i = 0; $i < $pages + 1; $i++) {
            if ($i != 0) {
                $crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection.'?page='.$i);
            }

            $crawler->filter('.product-item')->each(function ($node) use ($collection, $i) {
                $url   = str_replace('//cdn', 'http://cdn', $node->filter('img')->attr('src'));
                $file  = file_get_contents($url);
                $name  = explode('?v=', basename($url))[0];
                $sku   = explode('#', $node->filter('.product-sku')->text())[1];
                $title = trim($node->filter('.title a')->text());

                if (! is_dir($collection)) {
                    mkdir($collection);
                }

                $exists = Storage::disk('s3')->exists($collection.'/'.$sku.'.jpg');

                if (isset($sku) && is_numeric($sku) && ! $exists) {
                    Storage::disk('s3')->put($collection.'/'.$sku.'.jpg', $file, 'public');

                    return;
                }

                if (! $exists) {
                    Storage::disk('s3')->put($collection.'/'.Uuid::generate(1).'_VAULTED.jpg', $file, 'public');
                }
            });
        }

        return true;
    }
}
