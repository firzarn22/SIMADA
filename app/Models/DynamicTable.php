<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicTable extends Model
{
    use HasFactory;

    // Pastikan nama tabel kamu sudah sesuai, misal: 'dynamic_tables'
    protected $table = 'dynamic_tables';

    // 1. PASTIKAN 'headers' SUDAH MASUK KE DALAM FILLABLE DI BAWAH INI
    protected $fillable = [
        'menu_id',
        'judul_tabel',
        'deskripsi_tabel',
        'jumlah_kolom',
        'jumlah_baris',
        'headers',
        'header_levels',
        'rows'
    ];

    // 2. PASTIKAN 'headers' JUGA SUDAH DI-CAST MENJADI ARRAY DI BAWAH INI
    protected $casts = [
        'headers' => 'array', // <-- Ini wajib ada!
        'header_levels' => 'array',
        'rows' => 'array'
    ];

    // Relasi ke menu (opsional, jika kamu pakai)
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
