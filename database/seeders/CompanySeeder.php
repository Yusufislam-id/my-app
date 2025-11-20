<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'PT. Pawang Arutala Sugiharta',
                'code' => 'PAS',
                'is_active' => true,
            ],
            [
                'name' => 'PT. Muljadi Bangun Santoso',
                'code' => 'MBS',
                'is_active' => true,
            ],
            [
                'name' => 'PT. Yudha Muda Sakti',
                'code' => 'YMS',
                'is_active' => true,
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}