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
        Schema::create('rekap_pts', function (Blueprint $table) {
            $table->uuid('idRekapPts')->primary();
            $table->uuid('kelas');
            $table->uuid('kelasMapel');
            $table->uuid('siswa');
            $table->enum('semester', ['GENAP', 'GANJIL']);
            $table->decimal('nilaiAkademik', $precision = 5, $scale = 2)->default(0);
            $table->string('terbilangNilaiAkademik')->default('Nol');
            $table->decimal('nilaiKeterampilan', $precision = 5, $scale = 2)->default(0);
            $table->string('terbilangNilaiKeterampilan')->default('Nol');
            $table->longText('keterangan')->nullable(true);
            $table->foreign('kelas')->references('idKelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kelasMapel')->references('idKelasMapel')->on('kelas_mapel')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('siswa')->references('idSiswa')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_pts');
    }
};
