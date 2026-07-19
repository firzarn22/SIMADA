<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data menu
        $menus = Menu::whereNull('parent_id')->with('submenus')->get();

        // Paksa isi $stats dengan data kosong agar tidak error
        $stats = [
            (object)['label' => 'Data LLA', 'jumlah' => 0],
            (object)['label' => 'Data Sarpras', 'jumlah' => 0],
            (object)['label' => 'Data Parkir', 'jumlah' => 0],
            (object)['label' => 'Aktivitas', 'jumlah' => 0],
        ];

        return view('dashboard', compact('menus', 'stats'));
    }
}
