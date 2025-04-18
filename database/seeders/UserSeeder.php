<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hvas.com',
            'password' => Hash::make('password'),
            'role_id' => 1, // admin
        ]);

        // Teknisi
        User::create([
            'name' => 'Teknisi',
            'email' => 'teknisi@hvas.com',
            'password' => Hash::make('password'),
            'role_id' => 2, // teknisi
        ]);

        // User
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@hvas.com',
            'password' => Hash::make('password'),
            'role_id' => 3, // user biasa
        ]);
    }
}
