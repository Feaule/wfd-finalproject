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
    Schema::create('pembayaran', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tagihan_id')->constrained('tagihan')->onDelete('cascade');
        $table->date('tanggal');
        $table->string('bukti_foto'); // path file
        $table->string('metode')->nullable(); // transfer, tunai, dll
        $table->timestamp('verified_at')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
