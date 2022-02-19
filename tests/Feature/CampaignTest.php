<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Authenticatable;

class CampaignTest extends TestCase
{
    public function test_campaigns()
    {
    	$user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe'.rand(10,99).'@gmail.com',
            'password' => 'john1234',
        ]);
        
        $response = $this->actingAs($user)->get('/campaigns');
        $response->assertStatus(200);
    }
}
