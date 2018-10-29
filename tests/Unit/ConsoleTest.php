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
    public function testAddingResourceMethodN()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'n'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function testAddingResourceMethodR()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'r'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function testAddingResourceMethodA()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'a'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function testAddingResourceMethodNImmediately()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'n'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function testAddingResourceMethodRImmediately()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'r'
        ]);
        $this->assertEquals(0, $response);
    }
    
    public function testAddingResourceMethodAImmediately()
    {
        $response = $this->artisan('resource:download', [
            'url' => 'http://localhost:8000/testFile.txt', 
            '--method' => 'a'
        ]);
        $this->assertEquals(0, $response);
    }
}
