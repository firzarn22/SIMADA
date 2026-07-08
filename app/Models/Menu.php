<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['nama_menu', 'url', 'parent_id', 'icon'];

    // Relasi ke anak (Sub-Menu) - Kodingan kamu sebelumnya
    public function submenus() {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    // TAMBAHKAN INI: Relasi ke tabel dinamis
    public function dynamicTable() {
        return $this->hasOne(DynamicTable::class, 'menu_id');
    }
}
