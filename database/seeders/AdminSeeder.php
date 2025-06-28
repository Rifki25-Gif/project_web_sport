<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of admin users to create
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => 'password',
                'is_admin' => true,
            ],
            [
                'name' => 'Manager Admin',
                'email' => 'manager@example.com',
                'password' => 'password',
                'is_admin' => true,
            ],
        ];

        foreach ($admins as $admin) {
            // Check if admin already exists
            $existingAdmin = User::where('email', $admin['email'])->first();
            
            if (!$existingAdmin) {
                // Create admin with hashed password
                User::create([
                    'name' => $admin['name'],
                    'email' => $admin['email'],
                    'password' => Hash::make($admin['password']),
                    'is_admin' => $admin['is_admin'],
                ]);
                
                $this->command->info("Admin {$admin['name']} created successfully!");
            } else {
                $this->command->info("Admin {$admin['name']} already exists!");
            }
        }
    }
} 