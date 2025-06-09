<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('nib');
            $table->string('akun_facebook')->nullable()->after('lokasi');
            $table->string('akun_instagram')->nullable()->after('akun_facebook');
            $table->integer('total_pengikut_facebook')->default(0)->after('akun_instagram');
            $table->integer('total_pengikut_instagram')->default(0)->after('total_pengikut_facebook');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['lokasi', 'akun_facebook', 'akun_instagram', 'total_pengikut_facebook', 'total_pengikut_instagram']);
        });
    }
};