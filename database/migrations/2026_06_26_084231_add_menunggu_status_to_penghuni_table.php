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
        // MySQL: modify enum to add 'menunggu' value
        \DB::statement("ALTER TABLE penghuni MODIFY COLUMN status ENUM('aktif', 'tidak_aktif', 'menunggu') NOT NULL DEFAULT 'aktif'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement("ALTER TABLE penghuni MODIFY COLUMN status ENUM('aktif', 'tidak_aktif') NOT NULL DEFAULT 'aktif'");
    }
};
