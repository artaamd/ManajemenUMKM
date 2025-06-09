<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEngagementFilledAtToAnalitiksTable extends Migration
{
    public function up()
    {
        Schema::table('analitiks', function (Blueprint $table) {
            // Tambahkan kolom engagement_filled_at
            $table->dateTime('engagement_filled_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('analitiks', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn('engagement_filled_at');
        });
    }
}