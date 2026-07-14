<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun untuk Super Admin
        User::updateOrInsert(
            ['email' => 'LLA@dishub.go.id'],
            [
                'name' => 'Admin LLA SIMADA',
                'password' => Hash::make('LLA123'),
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Akun untuk Admin Perparkiran
        User::updateOrInsert(
            ['email' => 'Perparkiran@dishub.go.id'],
            [
                'name' => 'Admin Perparkiran SIMADA',
                'password' => Hash::make('Perparkiran123'),
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 3. Akun untuk Admin Sapras
        User::updateOrInsert(
            ['email' => 'Sapras@dishub.go.id'],
            [
                'name' => 'Admin Sapras SIMADA',
                'password' => Hash::make('Sapras123'),
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 4. Akun untuk Operator
        User::updateOrInsert(
            ['email' => 'operator@dishub.go.id'],
            [
                'name' => 'Operator SIMADA',
                'password' => Hash::make('operator123'),
                'role' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
