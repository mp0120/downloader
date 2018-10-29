<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConsoleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_list_of_resource()
    {
        $response = $this->artisan('resource:list');
        $this->assertEquals(0, $response);
    }
    
    public function test_adding_resource_method_n()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'n'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function test_adding_resource_method_r()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'r'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function test_adding_resource_method_a()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'a'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function test_adding_resource_method_n_immediately()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'n'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function test_adding_resource_method_r_immediately()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'r'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function test_adding_resource_method_a_immediately()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'a'
        ]);
        $this->assertEquals(0, $response);
    }
}
