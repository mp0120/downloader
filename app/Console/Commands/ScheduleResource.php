<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Resource;
use App\Http\Controllers\DownloadController;

class ScheduleResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run downloading of schedulled resources';

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
        foreach (Resource::where('status', Resource::PENDING)->cursor() as $resource) {
            DownloadController::downloadNow($resource->resource, $resource->method);
            if ( $resource->method ) {
                $resource->delete();
            }
        }
    }
}
