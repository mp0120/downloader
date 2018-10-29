<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Resource;

class ShowResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        
        $list = Resource::select('id', 'resource', 'status')->get()->toArray();
        $list = array_map(function ($resource) {
            $result['resource'] = $resource['resource'] . ' ';
            $result['link'] = url('download/' . $resource['id']) . ' ';
            switch ($resource['status']) {
                case Resource::PENDING:
                    $result['status'] = ' PENDING';
                    break;
                case Resource::DOWNLOADING:
                    $result['status'] = ' DOWNLOADING';
                    break;
                case Resource::ERROR:
                    $result['status'] = ' ERROR';
                    break;
                case Resource::COMPLETE:
                    $result['status'] = ' COMPLETE';
                    break;
            }
            
            return $result;
        }, $list);
        
        $fields_length = [
            'resource' => 0,
            'link' => 0,
            'status' => 0
        ];
        
        foreach ($list as $resource) {
            if ( strlen($resource['resource']) > $fields_length['resource'] ) {
                $fields_length['resource'] = strlen($resource['resource']);
            }
            if ( strlen($resource['link']) > $fields_length['link'] ) {
                $fields_length['link'] = strlen($resource['link']);
            }
            if ( strlen($resource['status']) > $fields_length['status'] ) {
                $fields_length['status'] = strlen($resource['status']);
            }
        }
        
        foreach ($list as $resource) {
            $output = '| ';
            $output .= $resource['resource'];
            for( $i = 0; $i < $fields_length['resource'] - strlen($resource['resource']); $i++) {
                $output .= ' ';
            }
            $output .= ' | ';
            $output .= $resource['link'];
            for( $i = 0; $i < $fields_length['link'] - strlen($resource['link']); $i++) {
                $output .= ' ';
            }
            $output .= ' | ';
            $output .= $resource['status'];
            for( $i = 0; $i < $fields_length['status'] - strlen($resource['status']); $i++) {
                $output .= ' ';
            }
            $output .= ' |';
            $this->info($output);
        }
    }
}
