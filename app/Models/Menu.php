<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['nama_menu', 'url', 'parent_id'];

    // Relasi ke anak (Sub-Menu)
    public function submenus() {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
