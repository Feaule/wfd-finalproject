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
    Schema::create('tagihan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('penghuni_id')->constrained('penghuni')->onDelete('cascade');
        $table->string('bulan'); // Format: '2026-06'
        $table->enum('jenis', ['sewa', 'listrik', 'air', 'kebersihan']);
        $table->decimal('jumlah', 12, 2);
        $table->enum('status', ['belum_bayar', 'menunggu_verifikasi', 'lunas'])
               ->default('belum_bayar');
        $table->date('jatuh_tempo');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
