<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Jangan lupa tambahkan ini!

class MenuController extends Controller
{
    public function index() {
            if (Auth::user()->role !== 'superadmin') {
        return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
    }

        $menus = Menu::all();
        $parents = Menu::whereNull('parent_id')->get();
        return view('admin.menu', compact('menus', 'parents'));
    }

    public function store(Request $request) {
        // HANYA Super Admin yang boleh menambah/mengubah struktur menu
        if (Auth::user()->role !== 'superadmin') {
            return abort(403, 'Akses ditolak! Hanya Super Admin yang bisa menambah menu.');
        }

        Menu::create($request->validate([
            'nama_menu' => 'required',
            'url' => 'required',
            'parent_id' => 'nullable'
        ]));

        return back()->with('success', 'Menu ditambahkan!');
    }

   public function destroy($id)
{
    $menu = Menu::findOrFail($id);

    // Hapus semua submenu
    Menu::where('parent_id', $menu->id)->delete();

    // Hapus menu
    $menu->delete();

    return redirect()->route('menu.index')
                     ->with('success', 'Menu berhasil dihapus.');
}

}
