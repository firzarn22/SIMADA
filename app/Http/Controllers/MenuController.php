<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Jangan lupa tambahkan ini!

class MenuController extends Controller
{
    public function index() {
            if (!in_array(Auth::user()->role, ['superadmin', 'operator'])) {
        return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
    }

        $menus = Menu::all();
        $parents = Menu::whereNull('parent_id')->get();
        return view('admin.menu', compact('menus', 'parents'));
    }

    public function store(Request $request) {
        if (!in_array(Auth::user()->role, ['superadmin', 'operator'])) {
            return abort(403, 'Akses ditolak!');
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
    if(Auth::user()->role !== 'superadmin') {
        abort(403, 'Akses ditolak!');
    }
    $menu = Menu::findOrFail($id);

    // Hapus semua submenu
    Menu::where('parent_id', $menu->id)->delete();

    // Hapus menu
    $menu->delete();

    return redirect()->route('menu.index')
                     ->with('success', 'Menu berhasil dihapus.');
}

}
