<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'phone' => '6289514596741',
        'active' => 1,
        'role' => 'admin',
        'token' => 123456,
        'password' => Hash::make('12345678'),
        ]);
    }
}
