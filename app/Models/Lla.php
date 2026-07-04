<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lla extends Model
{
    // Ini kolom yang nantinya akan kamu isi di tabel llas
    protected $fillable = ['nama', 'keterangan'];
}
