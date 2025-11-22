<?php

namespace Database\Seeders;

use App\Models\Practitioner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminPractitionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Practitioner::updateOrCreate(
            ['email' => 'admin@klinik.test'],
            [
                'tenant_id' => 1,
                'full_name' => 'Admin Klinik',
                'role' => 'admin',
                'phone' => '08123456789',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]
        );
    }
}
