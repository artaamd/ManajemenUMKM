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
        Schema::table('analitiks', function (Blueprint $table) {
            // Menambahkan kolom baru untuk menyimpan URL postingan
            // `after('shares')` berarti kolom ini akan dibuat setelah kolom 'shares'
            $table->text('link_postingan')->nullable()->after('shares');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analitiks', function (Blueprint $table) {
            // Perintah untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('link_postingan');
        });
    }
};
