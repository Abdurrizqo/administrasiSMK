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
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->uuid('idKelasSiswa')->primary();
            $table->uuid('idKelas');
            $table->uuid('idSiswa');
            $table->foreign('idKelas')->references('idKelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idSiswa')->references('idSiswa')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_siswa');
    }
};
