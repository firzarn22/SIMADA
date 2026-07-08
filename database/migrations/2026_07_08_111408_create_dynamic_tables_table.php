<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade'); // Menghubungkan ke id di tabel menus kamu
            $table->string('judul_tabel');
            $table->text('deskripsi_tabel')->nullable();
            $table->integer('jumlah_kolom');
            $table->integer('jumlah_baris');
            $table->json('headers'); // Menyimpan nama-nama kolom
            $table->json('rows');    // Menyimpan isi baris tabel
            $table->timestamps();

            // Otomatis menghapus tabel dinamis jika menu aslinya dihapus
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_tables');
    }
};
