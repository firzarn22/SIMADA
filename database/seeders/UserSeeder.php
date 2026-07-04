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
        User::create([
            'name' => 'Super Admin SIMADA',
            'email' => 'superadmin@dishub.go.id',
            'password' => Hash::make('admin123'),
            'role' => 'superadmin',
        ]);

        // 2. Akun untuk Operator
        User::create([
            'name' => 'Operator SIMADA',
            'email' => 'operator@dishub.go.id',
            'password' => Hash::make('operator123'),
            'role' => 'operator',
        ]);
    }
}
