<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User 1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'User 2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'User 3',
            'email' => 'user3@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
