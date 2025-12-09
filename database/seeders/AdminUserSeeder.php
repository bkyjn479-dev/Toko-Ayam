<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@stockwing.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '08123456789',
                'address' => 'Jalan Admin No. 1',
                'city' => 'Jakarta',
                'email_verified_at' => now(),
            ]
        );

        // Create sample customer user
        User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Customer',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '08987654321',
                'address' => 'Jalan Pelanggan No. 5',
                'city' => 'Surabaya',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin and sample customer users created successfully!');
    }
}
