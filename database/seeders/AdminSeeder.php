<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('ADMIN_PASSWORD');

        if (!$password) {
            $this->command->error('ADMIN_PASSWORD is not set in .env — skipping admin seeder.');
            return;
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@apexhardware.com'],
            [
                'first_name'         => 'Admin',
                'last_name'          => 'User',
                'phone_number'       => null,
                'role'               => 'admin',
                'password'           => Hash::make($password),
                'password_changed'   => true,  // treat seeded admin as already configured
                'email_verified_at'  => now(),
            ]
        );

        // Safety: if account existed but lost admin role somehow, restore it
        if ($admin->role !== 'admin') {
            $admin->update(['role' => 'admin']);
        }
    }
}