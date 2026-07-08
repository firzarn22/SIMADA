<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicTable;
use App\Models\Menu;

class DynamicTableController extends Controller
{
    // Fungsi yang dipanggil saat sub-menu diklik dari sidebar
    public function show($menu_id)
    {
        // Ambil data menu berdasarkan ID untuk tahu nama halamannya
        $menu = Menu::findOrFail($menu_id);

        // Cari tahu apakah menu ini sudah pernah dibuatkan tabelnya atau belum
        $tableData = DynamicTable::where('menu_id', $menu_id)->first();

        // Kirim data menu dan data tabel ke view yang sama
        return view('admin.view_table', compact('tableData', 'menu'));
    }

    // Fungsi untuk memproses penyimpanan tabel saat tombol "Simpan & Kunci" diklik
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
            'judul_tabel' => 'required|string|max:255',
            'jumlah_kolom' => 'required|integer|min:1',
            'jumlah_baris' => 'required|integer|min:1',
            'headers' => 'required|array',
            'rows' => 'required|array',
        ]);

        // Kita ambil semua input, lalu bersihkan array headers & rows agar murni array javascript
        $data = $request->all();
        $data['headers'] = array_values($request->input('headers', []));
        $data['rows'] = array_values($request->input('rows', []));

        DynamicTable::create($data);

        return redirect()->back()->with('success_table', 'Tabel berhasil dibuat langsung di halaman ini!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_tabel' => 'required|string|max:255',
            'jumlah_kolom' => 'required|integer|min:1',
            'jumlah_baris' => 'required|integer|min:1',
            'headers' => 'required|array',
            'rows' => 'required|array',
        ]);

        $table = DynamicTable::findOrFail($id);

        // Kita paksa susun ulang array-nya agar index-nya berurutan (0, 1, 2...)
        $headers = array_values($request->input('headers', []));
        $rows = array_values($request->input('rows', []));

        $table->update([
            'judul_tabel' => $request->judul_tabel,
            'deskripsi_tabel' => $request->deskripsi_tabel,
            'jumlah_kolom' => $request->jumlah_kolom,
            'jumlah_baris' => $request->jumlah_baris,
            'headers' => $headers, // Dikunci manual
            'rows' => $rows,       // Dikunci manual
        ]);

        return redirect()->back()->with('success_table', 'Tabel berhasil diperbarui!');
    }
    public function destroyTable($id)
    {
        $table = DynamicTable::findOrFail($id);
        $table->delete();

        return redirect()->back()->with('success_table', 'Tabel data berhasil dihapus dari halaman ini.');
    }
}
