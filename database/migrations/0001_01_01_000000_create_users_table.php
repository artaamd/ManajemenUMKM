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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('role');

        // Kolom-kolom tambahan untuk UMKM
        $table->string('nib')->nullable();
        $table->string('profile_image')->nullable();
        $table->string('lokasi')->nullable();
        $table->string('akun_facebook')->nullable();
        $table->string('akun_instagram')->nullable();

        // TAMBAHKAN KOLOM YANG HILANG DI SINI
        $table->integer('total_pengikut_facebook')->default(0)->nullable(); 

        $table->integer('total_pengikut_instagram')->default(0)->nullable();

        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
