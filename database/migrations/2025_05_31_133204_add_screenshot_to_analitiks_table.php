<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScreenshotToAnalitiksTable extends Migration
{
    public function up()
    {
        Schema::table('analitiks', function (Blueprint $table) {
            $table->string('screenshot')->nullable()->after('shares');
        });
    }

    public function down()
    {
        Schema::table('analitiks', function (Blueprint $table) {
            $table->dropColumn('screenshot');
        });
    }
}