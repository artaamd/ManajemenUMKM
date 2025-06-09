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
        Schema::create('kontens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained()->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->dateTime('tanggal_publish');
            $table->enum('platform', ['facebook', 'instagram']);
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontens');
    }
};
