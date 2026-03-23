<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'first_name'        => 'Test',
                'last_name'         => 'User',
                'phone_number'      => null,
                'role'              => 'customer',
                'password'          => Hash::make('password'),
                'password_changed'  => true,
                'email_verified_at' => now(),
            ]
        );
    }
}