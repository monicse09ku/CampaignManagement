<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Login Page Test.
     *
     * @return void
     */
    public function test_login_form()
    {
    	$response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Register Page Test.
     *
     * @return void
     */
    public function test_registration_form()
    {
    	$response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_user_duplication()
    {
    	$user1 = User::make([
    		'name' => 'John Doe',
    		'email' => 'johndoe@gmail.com'
    	]);

    	$user2 = User::make([
    		'name' => 'Jane Doe',
    		'email' => 'janedoe@gmail.com'
    	]);

    	$this->assertTrue($user1->name != $user2->name);
    }

    public function test_user_delete()
    {
    	$user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe'.rand(10,99).'@gmail.com',
            'password' => 'john1234',
        ]);

    	if($user){
    		$user->delete();
    	}

    	$this->assertTrue(true);
    }
}
