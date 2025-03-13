<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Ensure a hashed password
            'role' => 'admin',
        ]);

        // Create a default regular user
        User::create([
            'name' => 'Vincent Baldon',
            'email' => 'vincentbaldon@gmail.com',
            'password' => Hash::make('vincent12345'),
            'role' => 'user',
        ]);
    }
}
