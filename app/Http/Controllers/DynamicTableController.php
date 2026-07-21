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
        if (!in_array(auth()->user()->role, ['superadmin', 'operator'])) {
            abort(403, 'Akses ditolak!');
    }
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
        if (!in_array(auth()->user()->role, ['superadmin', 'operator'])) {
            abort(403, 'Akses ditolak!');
        }
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
            'header_levels' => $table->header_levels,
            'rows' => $rows,
        ]);

        return redirect()->back()->with('success_table', 'Tabel berhasil diperbarui!');
    }

    public function destroyTable($id)
    {
        if (auth()->user()->role !== 'superadmin') {
        abort(403, 'Akses ditolak!');
    }
        $table = DynamicTable::findOrFail($id);
        $table->delete();

        return redirect()->back()->with('success_table', 'Tabel data berhasil dihapus dari halaman ini.');
    }

   public function export($menu_id)
{
    $table = DynamicTable::where('menu_id', $menu_id)->firstOrFail();

    $filename = 'Data_' . date('YmdHis') . '.csv';

    return response()->streamDownload(function () use ($table) {

        $output = fopen('php://output', 'w');

        // Tambahkan UTF-8 BOM agar Excel membaca karakter dengan benar
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header
        fputcsv($output, $table->headers, ';');

        // Data
        foreach ($table->rows as $row) {
            fputcsv($output, $row, ';');
        }

        fclose($output);

    }, $filename, [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
    ]);
}

public function import(Request $request, $menu_id)
{
    if (!in_array(auth()->user()->role, ['superadmin', 'operator'])) {
        abort(403, 'Akses ditolak!');
    }

    $request->validate([
        'file' => 'required|mimes:csv,txt',
    ]);

    $file = fopen($request->file('file')->getRealPath(), 'r');

    // Deteksi delimiter
    $firstLine = fgets($file);
    rewind($file);

    $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',')
        ? ';'
        : ',';

    $header1 = fgetcsv($file, 1000, $delimiter);

$pos = ftell($file);
$header2 = fgetcsv($file, 1000, $delimiter);

$isDataRow = isset($header2[0]) &&
    (is_numeric(str_replace('.', '', $header2[0])) ||
     preg_match('/^\d+\.?$/', trim($header2[0])));

if ($isDataRow) {

    // ===== HEADER 1 BARIS =====
    $headers = $header1;

    fseek($file, $pos);

} else {

    // ===== HEADER 2 / 3 BARIS =====
    $headers = [];

    for ($i = 0; $i < count($header1); $i++) {

        $main = trim($header1[$i] ?? '');
        $sub  = trim($header2[$i] ?? '');

        if ($main != '' && $sub != '') {
            $headers[] = $main . ' ' . $sub;
        } elseif ($main != '') {
            $headers[] = $main;
        } else {
            $headers[] = $sub;
        }
    }

}

    // Ambil isi data
    $rows = [];

    while (($data = fgetcsv($file, 1000, $delimiter)) !== false) {
        $rows[] = $data;
    }

    fclose($file);

    // Cari apakah tabel sudah ada
    $table = DynamicTable::where('menu_id', $menu_id)->first();

    if ($table) {

        $table->update([
            'headers' => $headers,
            'rows' => $rows,
            'jumlah_kolom' => count($headers),
            'jumlah_baris' => count($rows),
        ]);

    } else {

        DynamicTable::create([
            'menu_id' => $menu_id,
            'judul_tabel' => pathinfo(
                $request->file('file')->getClientOriginalName(),
                PATHINFO_FILENAME
            ),
            'deskripsi_tabel' => 'Import CSV',
            'jumlah_kolom' => count($headers),
            'jumlah_baris' => count($rows),
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    return redirect()
        ->route('dynamic-table.show', $menu_id)
        ->with('success_table', 'CSV berhasil diimport.');
}

public function chart($id)
{
    $table = DynamicTable::findOrFail($id);

    $headers = json_decode($table->headers, true);
    $rows = json_decode($table->rows, true);

    if (!$headers || !$rows) {
        return back()->with('error','Tidak ada data.');
    }

    $labelColumn = $headers[0];

    $labels = [];
    $datasets = [];

    foreach ($headers as $header){

        if($header == $labelColumn){
            continue;
        }

        $datasets[$header]=[
            'label'=>$header,
            'data'=>[]
        ];
    }

    foreach($rows as $row){

        $labels[] = $row[$labelColumn] ?? '';

        foreach($datasets as $key=>&$dataset){

            $dataset['data'][] =
                isset($row[$key]) && is_numeric($row[$key])
                ? (float)$row[$key]
                : 0;

        }

    }

    return view(
        'dynamic_tables.chart',
        compact(
            'table',
            'labels',
            'datasets'
        )
    );

}
}
