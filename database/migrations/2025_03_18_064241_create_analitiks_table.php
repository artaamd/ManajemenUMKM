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
        $table->foreignId('konten_id')->constrained('kontens')->onDelete('cascade');
        $table->enum('platform', ['instagram', 'facebook']);
        $table->integer('likes')->default(0);
        $table->integer('shares')->default(0);
        $table->string('screenshot')->nullable();
        $table->integer('comments')->default(0);
        $table->integer('reach')->default(0)->nullable();
        $table->float('engagement_rate', 8, 2)->nullable();
        $table->string('grade')->nullable();
        $table->dateTime('engagement_filled_at')->nullable();
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
