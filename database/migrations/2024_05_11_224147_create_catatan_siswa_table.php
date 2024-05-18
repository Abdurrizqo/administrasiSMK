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
        Schema::create('catatan_siswa', function (Blueprint $table) {
            $table->uuid('idCatatanSiswa')->primary();
            $table->enum('kategori', ['CAPAIAN', 'PELANGGARAN']);
            $table->longText('keterangan');
            $table->uuid('idSiswa');
            $table->foreign('idSiswa')->references('idSiswa')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_siswa');
    }
};
