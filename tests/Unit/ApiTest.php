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
    public function testAddingResourceMethodN()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'n'
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
    
    public function testAddingResourceMethodR()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'r'
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
    
    public function testAddingResourceMethodA()
    {
        $response = $this->call('POST', '/api/download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'flags' => [
                'm' => 'a'
            ]
        ]);
        $this->assertEquals(202, $response->status());
    }
    
    public function testAddingResourceMethodNImmediately()
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
    
    public function testAddingResourceMethodRImmediately()
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
    
    public function testAddingResourceMethodAImmediately()
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
