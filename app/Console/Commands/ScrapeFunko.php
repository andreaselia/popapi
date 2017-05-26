<?php

namespace App\Console\Commands;

use Uuid;
use Goutte;
use Storage;
use App\Result;
use App\Collection;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class ScrapeFunko extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:funko {--reset}';

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
        if ($this->option('reset')) {
            Collection::truncate();

            Result::truncate();
        }

        $bar = $this->output->createProgressBar(count($this->collections));

        foreach ($this->collections as $collection) {
            if ($this->scrape($collection, $this->option('reset'))) {
                $bar->advance();
            }
        }

        $bar->finish();
    }

    /**
     * For scraping data for the specified collection.
     *
     * @param  string $collection
     * @return boolean
     */
    public static function scrape($collection, $reset)
    {
        $crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection);

        $collection_name = $crawler->filter('.breadcrumbs.colored-links li:last-child')->text();

        $collection = Collection::firstOrCreate([
            'name' => $collection_name,
            'slug' => $collection,
        ]);

        $pages = $crawler->filter('footer .pagination li')->count() > 0
            ? $crawler->filter('footer .pagination li:nth-last-child(2)')->text()
            : 0
        ;

        for ($i = 0; $i < $pages + 1; $i++) {
            if ($i != 0) {
                $crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection->slug.'?page='.$i);
            }

            $crawler->filter('.product-item')->each(function ($node) use ($collection, $reset, $i) {
                $url   = str_replace('//cdn', 'http://cdn', $node->filter('img')->attr('src'));
                $file  = file_get_contents($url);
                $sku   = explode('#', $node->filter('.product-sku')->text())[1];
                $name  = trim($node->filter('.title a')->text());
                $slug  = explode('/', trim($node->filter('.title a')->attr('href')));
                $slug  = $slug[count($slug) - 1];
                $url   = urlencode(env('FUNKO_POP_URL').'/products/'.$slug);

                $exists = Storage::disk('s3')->exists($collection->slug.'/'.$sku.'.jpg');

                if ($reset || (isset($sku) && is_numeric($sku) && ! $exists)) {
                    Storage::disk('s3')->put($collection->slug.'/'.$sku.'.jpg', $file, 'public');

                    $s3 = urlencode(
                        'https://s3-'.env('S3_REGION').'.amazonaws.com/'.env('S3_BUCKET').'/'.$collection->slug.'/'.$sku.'.jpg'
                    );

                    $result = Result::firstOrCreate([
                        'collection_id' => $collection->id,
                        'name'          => $name,
                        'slug'          => $slug,
                        'sku'           => $sku,
                        'image'         => $s3,
                        'url'           => $url,
                    ]);

                    return;
                }

                if ($reset || ! $exists) {
                    Storage::disk('s3')->put($collection->slug.'/'.Uuid::generate(1).'_VAULTED.jpg', $file, 'public');

                    $s3 = urlencode(
                        'https://s3-'.env('S3_REGION').'.amazonaws.com/'.env('S3_BUCKET').'/'.$collection->slug.'/'.Uuid::generate(1).'_VAULTED.jpg'
                    );

                    $result = Result::firstOrCreate([
                        'collection_id' => $collection->id,
                        'sku'           => $sku,
                        'image'         => $s3,
                    ]);
                }
            });
        }

        return true;
    }
}
