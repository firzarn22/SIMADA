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
            ['email' => 'superadmin@dishub.go.id'],
            [
                'name' => 'Super Admin SIMADA',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Akun untuk Operator
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
