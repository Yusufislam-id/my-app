<?php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Pt;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'form.view',
            'form.create',
            'form.edit',
            'form.delete',
            'file.upload',
            'file.view',
            'file.delete',
            'access.all_pt'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'admin_keuangan' => ['form.view', 'form.create', 'form.edit', 'form.delete', 'file.upload', 'file.view'],
            'admin_berkas' => ['form.view', 'form.create', 'form.edit', 'form.delete', 'file.upload', 'file.view', 'file.delete'],
            'direktur_pt' => ['form.view', 'file.view'],
            'komisaris_pt' => ['form.view', 'file.view'],
            'founder' => ['form.view', 'file.view', 'access.all_pt']
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($rolePermissions);
        }

        // Create PTs
        $ptData = [
            'PT.Pawang Arutala Sugiharta' => 'PAS',
            'PT.Muljadi Bangun Santoso' => 'MBS',
            'PT.Yudha Muda Sakti' => 'YMS',
            'PT.Mita Anne Propetindo' => 'MAP',
            'PT.Anaya Sukses Bersama' => 'ASB',
            'PT.Samudro Mulyo Joyo' => 'SMJ',
            'PT.Sigit Nawa Sejahtera' => 'SNS'
        ];

        foreach ($ptData as $name => $code) {
            Pt::create([
                'name' => $name,
                'code' => $code,
                'is_active' => true
            ]);
        }
    }
}
