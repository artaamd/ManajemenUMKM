<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNibNullableInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nib')->nullable()->change(); // Ubah nib menjadi nullable
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nib')->nullable(false)->change(); // Kembalikan ke non-nullable
        });
    }
}