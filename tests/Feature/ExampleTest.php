<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function testNoModuleCompleted() {
        $response = $this->json('GET', 'api/api_example_contact_add', ['email' => '5b3a29e1d32ef@test.com',]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'update_reminder' => true,
            ]);
    }
    
    public function testModuleReminderAssigner() {        
        $response = $this->json('POST', 'api/module_reminder_assigner', ['contact_email' => '5b3a29e1d32ef@test.com']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'update_reminder' => true,
            ]);
    }
    
    public function testModuleCompleted() {
        
        $response = $this->json('POST', 'api/module_reminder_assigner', ['contact_email' => '5b3a29e1d32ef@test.com']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'update_reminder' => true,
            ]);
    }
}
