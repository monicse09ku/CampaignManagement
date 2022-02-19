<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use CampaignSeeder;
use UserSeeder;

class UserTest extends TestCase
{
    
    public function test_it_stores_new_user()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'janedoe'.rand(10,99).'@gmail.com',
            'password' => 'john1234',
            'password_confirmation' => 'john1234',

        ]);

        $response->assertRedirect('/home');
    }

    public function test_if_seeders_works()
    {
        // $this->seed();
        $this->seed(CampaignSeeder::class);
        // $this->seed(UserSeeder::class);
    }
}
