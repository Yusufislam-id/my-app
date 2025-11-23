<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create one company
        $company = Company::firstOrCreate(
            ['code' => 'DEMO'],
            [
                'name' => 'PT. Demo Company',
                'is_active' => true,
            ]
        );

        $this->command->info('Company created: ' . $company->name);

        // Define all users with their roles
        $users = [
            // Super Admin (no company)
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => 'password',
                'role' => 'super_admin',
                'company_id' => null,
            ],
            // Founder (no company)
            [
                'name' => 'Founder',
                'email' => 'founder@example.com',
                'password' => 'password',
                'role' => 'founder',
                'company_id' => null,
            ],
            // Direktur (with company)
            [
                'name' => 'Direktur',
                'email' => 'direktur@example.com',
                'password' => 'password',
                'role' => 'direktur',
                'company_id' => $company->id,
            ],
            // Komisaris (with company)
            [
                'name' => 'Komisaris',
                'email' => 'komisaris@example.com',
                'password' => 'password',
                'role' => 'komisaris',
                'company_id' => $company->id,
            ],
            // Admin Pemberkasan (with company)
            [
                'name' => 'Admin Pemberkasan',
                'email' => 'admin.pemberkasan@example.com',
                'password' => 'password',
                'role' => 'admin_pemberkasan',
                'company_id' => $company->id,
            ],
            // Admin Keuangan (with company)
            [
                'name' => 'Admin Keuangan',
                'email' => 'admin.keuangan@example.com',
                'password' => 'password',
                'role' => 'admin_keuangan',
                'company_id' => $company->id,
            ],
        ];

        // Create users
        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'company_id' => $userData['company_id'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            if ($user->wasRecentlyCreated) {
                $this->command->info("✓ Created: {$userData['name']} ({$userData['role']}) - {$userData['email']}");
            } else {
                $this->command->warn("⊘ Already exists: {$userData['name']} ({$userData['role']}) - {$userData['email']}");
            }
        }

        $this->command->newLine();
        $this->command->info('All accounts created successfully!');
        $this->command->warn('Default password for all accounts: password');
        $this->command->warn('Please change the passwords after first login!');
    }
}

