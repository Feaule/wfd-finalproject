<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penghuni_id')->constrained('penghuni')->onDelete('cascade');
            $table->enum('kategori', ['listrik', 'air', 'kebersihan', 'keamanan', 'fasilitas', 'lainnya']);
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->enum('status', ['pending', 'proses', 'selesai', 'ditolak'])->default('pending');
            $table->text('tanggapan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
