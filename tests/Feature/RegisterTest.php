<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_successfully()
{
    $response = $this->postJson('/api/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'phone_number' => '08999999999',
        'address' => 'Test Street',
        'pin' => '123456',
    ]);

    $response->assertStatus(200)->assertJson([
        'status' => 'SUCCESS'
    ]);
}

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}


