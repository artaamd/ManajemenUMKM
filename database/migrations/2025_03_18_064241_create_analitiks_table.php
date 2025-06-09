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
        Schema::create('analitiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konten_id')->constrained()->onDelete('cascade');
            $table->enum('platform', ['facebook', 'instagram']);
            $table->integer('likes')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('comments')->default(0);
            $table->integer('reach')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analitiks');
    }
};
