<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('statistics', function (Blueprint $table) {
        // Menambahkan kolom dynamic_table_id setelah id
        $table->unsignedBigInteger('dynamic_table_id')->after('id');
    });
}

public function down(): void
{
    Schema::table('statistics', function (Blueprint $table) {
        $table->dropColumn('dynamic_table_id');
    });
}
};
