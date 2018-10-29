<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_resources_list()
    {
        $response = $this->call('POST', '/api/list');
        $this->assertEquals(200, $response->status());
    }
    
    public function test_adding_resource_method_n()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'n'
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
    
    public function test_adding_resource_method_r()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'r'
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
    
    public function test_adding_resource_method_a()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'a'
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
    
    public function test_adding_resource_method_n_immediately()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'n',
                'i' => true
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
    
    public function test_adding_resource_method_r_immediately()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'r',
                'i' => true
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
    
    public function test_adding_resource_method_a_immediately()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'a',
                'i' => true
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
}
