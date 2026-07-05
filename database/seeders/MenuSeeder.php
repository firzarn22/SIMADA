<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <--- WAJIB TAMBAHKAN INI

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menus')->insert([
            ['nama_menu' => 'Dashboard Utama', 'url' => '/dashboard'],
            ['nama_menu' => 'LLA', 'url' => '/lla'],
            ['nama_menu' => 'Bidang Perparkiran', 'url' => '#'],
            ['nama_menu' => 'Bidang Keselamatan', 'url' => '#'],
            ['nama_menu' => 'Bidang Sapras', 'url' => '#'],
        ]);
    }
}
