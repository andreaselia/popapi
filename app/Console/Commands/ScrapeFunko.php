<?php

namespace App\Console\Commands;

use App\Scrape;
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
    protected $description = 'Run the Scraper for Funko';

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
        Scrape::funko('animation');
        // Scrape::funko('disney');
        // Scrape::funko('games');
        // Scrape::funko('heroes');
        // Scrape::funko('marvel');
        // Scrape::funko('monster-high');
        // Scrape::funko('movies');
        // Scrape::funko('pets');
        // Scrape::funko('rocks');
        // Scrape::funko('sports');
        // Scrape::funko('star-wars');
        // Scrape::funko('television');
        // Scrape::funko('the-vault');
        // Scrape::funko('the-vote');
        // Scrape::funko('ufc');
    }
}
