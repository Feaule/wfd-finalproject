<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('unit', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lantai_id')->constrained('lantai')->onDelete('cascade');
        $table->string('nomor');
        $table->string('tipe')->nullable();
        $table->integer('luas_m2')->nullable();
        $table->decimal('harga_sewa', 12, 2);
        $table->enum('status', ['tersedia', 'terisi'])->default('tersedia');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit');
    }
};
