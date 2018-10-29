<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMainPage()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }
    
    public function testAddingResourceMethodN()
    {
        $response = $this->call('POST', '/', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'method' => 'n'
        ]);
        $this->assertEquals(302, $response->status());
    }
    
    public function testAddingResourceMethodR()
    {
        $response = $this->call('POST', '/', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'method' => 'r'
        ]);
        $this->assertEquals(302, $response->status());
    }
    
    public function testAddingResourceMethodA()
    {
        $response = $this->call('POST', '/', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'method' => 'a'
        ]);
        $this->assertEquals(302, $response->status());
    }
    
    public function testAddingResourceMethodNImmediately()
    {
        $response = $this->call('POST', '/', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'method' => 'n',
            'immediately' => 'checked'
        ]);
        $this->assertEquals(302, $response->status());
    }
    
    public function testAddingResourceMethodRImmediately()
    {
        $response = $this->call('POST', '/', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'method' => 'r',
            'immediately' => 'checked'
        ]);
        $this->assertEquals(302, $response->status());
    }
    
    public function testAddingResourceMethodAImmediately()
    {
        $response = $this->call('POST', '/', [
            'url' => 'http://localhost:8000/testFile.txt', 
            'method' => 'a',
            'immediately' => 'checked'
        ]);
        $this->assertEquals(302, $response->status());
    }
}
