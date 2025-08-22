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
        // Relasi yang benar langsung ke tabel 'users'
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('judul');
        $table->text('deskripsi')->nullable();
        $table->string('image')->nullable();
        $table->date('tanggal_publish')->nullable();
        $table->enum('platform', ['instagram', 'facebook']);
        $table->enum('status', ['draft', 'published'])->default('draft');
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
