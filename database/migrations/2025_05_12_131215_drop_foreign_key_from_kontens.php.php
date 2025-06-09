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
    Schema::table('kontens', function (Blueprint $table) {
        $table->dropForeign(['umkm_id']); // Pastikan nama kolom sesuai
    });

    // Opsional: Hapus kolom umkm_id jika tidak lagi diperlukan
    Schema::table('kontens', function (Blueprint $table) {
        $table->dropColumn('umkm_id');
    });
}

public function down(): void
{
    Schema::table('kontens', function (Blueprint $table) {
        $table->foreignId('umkm_id')->constrained('umkms')->onDelete('cascade');
    });
}
};
