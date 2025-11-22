<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'user'      => 'User Management',
            'poli'      => 'Poli',
            'doctor'    => 'Dokter',
            'insurance' => 'Asuransi',
            'queue'     => 'Antrian',
            // tambahkan module lain sesuai kebutuhan
        ];

        $actions = ['read', 'create', 'update', 'delete'];

        foreach ($modules as $key => $label) {
            foreach ($actions as $action) {
                $name = "{$key}.{$action}";

                Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web']
                );
            }
        }
    }
}
