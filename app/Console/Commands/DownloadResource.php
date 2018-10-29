<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DownloadController;
use App\Resource;

class DownloadResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:download {url} {--M|method=n} {--I|immediately}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "\r\n"
            . "-M | --method can be n, r, a\r\n"
            . "n - add new resource for this url\r\n"
            . "r - rewrite last resource for this url\r\n"
            . "a - rewrite all resources for this url\r\n"
            . "-I | --immediately If flag is set then resource will download right now.";

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
        //
        $url = $this->argument('url');
        $options = $this->options();
        
        if ( $options['immediately'] ) {
            if ( DownloadController::downloadNow($url, $options['method']) == Resource::COMPLETE ) {
                $this->info("Resource is downloaded");
            } else {
                $this->warn("Resource not found");
            }
        } else {
            DownloadController::addToSchedule($url, $options['method']);
            $this->info("Resource added to queue");
        }
    }
}
