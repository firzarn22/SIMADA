<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicTable;
use App\Models\Menu;
use App\Models\Statistic;

class DynamicTableController extends Controller
{
    // Fungsi untuk menampilkan tabel dan data statistik terkait
    public function show($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);

        // Cari data tabel berdasarkan menu_id
        $tableData = DynamicTable::where('menu_id', $menu_id)->first();

        // Ambil data statistik hanya yang memiliki dynamic_table_id yang sama dengan tabel yang dibuka
        // Jika tabel belum dibuat, maka $chartData akan kosong
        $chartData = $tableData ? Statistic::where('dynamic_table_id', $tableData->id)->get() : collect();

        return view('admin.view_table', compact('tableData', 'menu', 'chartData'));
    }

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

        $headers = array_values($request->input('headers', []));
        $rows = array_values($request->input('rows', []));

        $table->update([
            'judul_tabel' => $request->judul_tabel,
            'deskripsi_tabel' => $request->deskripsi_tabel,
            'jumlah_kolom' => $request->jumlah_kolom,
            'jumlah_baris' => $request->jumlah_baris,
            'headers' => $headers,
            'rows' => $rows,
        ]);

        return redirect()->back()->with('success_table', 'Tabel berhasil diperbarui!');
    }

    public function destroyTable($id)
    {
        $table = DynamicTable::findOrFail($id);
        $table->delete();

        return redirect()->back()->with('success_table', 'Tabel data berhasil dihapus dari halaman ini.');
    }

    public function export($menu_id)
{
    $tableData = \App\Models\DynamicTable::where('menu_id', $menu_id)->first();
    $fileName = 'data_tabel_' . time() . '.csv';

    $headers = array(
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    );

    $callback = function() use ($tableData) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $tableData->headers); // Baris judul kolom
        foreach ($tableData->rows as $row) {
            fputcsv($file, $row); // Baris data
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function import(Request $request, $menu_id)
{
    $request->validate(['file' => 'required|mimes:csv,txt']);

    $file = fopen($request->file('file')->getRealPath(), 'r');
    $headers = fgetcsv($file); // Ambil baris pertama sebagai header
    $rows = [];
    while (($data = fgetcsv($file)) !== FALSE) {
        $rows[] = $data; // Ambil baris data
    }
    fclose($file);

    $table = \App\Models\DynamicTable::where('menu_id', $menu_id)->first();
    $table->update([
        'headers' => $headers,
        'rows' => $rows
    ]);

    return redirect()->back()->with('success_table', 'Data berhasil di-import!');
}
}
