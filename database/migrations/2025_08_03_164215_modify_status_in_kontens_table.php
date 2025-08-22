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
        // Mengubah kolom untuk menambahkan 'scheduled'
        $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft')->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kontens', function (Blueprint $table) {
            //
        });
    }
};
