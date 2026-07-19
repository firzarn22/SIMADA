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
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Akun untuk Operator 1
        User::updateOrInsert(
            ['email' => 'op1@dishub.go.id'],
            [
                'name' => 'Operator SIMADA 1',
                'password' => Hash::make('op111'),
                'role' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 3. Akun untuk Operator 2
        User::updateOrInsert(
            ['email' => 'op2@dishub.go.id'],
            [
                'name' => 'Operator SIMADA 2',
                'password' => Hash::make('op222'),
                'role' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 4. Akun untuk Operator 3
        User::updateOrInsert(
            ['email' => 'op3@dishub.go.id'],
            [
                'name' => 'Operator SIMADA 3',
                'password' => Hash::make('op333'),
                'role' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 5. Akun untuk Executive User
        User::updateOrInsert(
            ['email' => 'excuser@dishub.go.id'],
            [
                'name' => 'Executive User SIMADA',
                'password' => Hash::make('execuser123'),
                'role' => 'excuser',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            );
            }
}
