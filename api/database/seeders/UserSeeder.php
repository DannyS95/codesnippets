<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => "danny",
            'email' => "danny@codesnipp.com",
            'password' => bcrypt('password'),
            'username' => 'dannys95'
        ]);
    }
}
