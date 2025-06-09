<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAnalitiksTable extends Migration
{
    public function up()
    {
        Schema::table('analitiks', function (Blueprint $table) {
            $table->float('engagement_rate', 8, 2)->nullable();
            $table->string('grade')->nullable();
        });
    }

    public function down()
    {
        Schema::table('analitiks', function (Blueprint $table) {
            $table->dropColumn(['engagement_rate', 'grade']);
        });
    }
}