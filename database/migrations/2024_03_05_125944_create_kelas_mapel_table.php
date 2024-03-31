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
        Schema::create('kelas_mapel', function (Blueprint $table) {
            $table->uuid('idKelasMapel')->primary();
            $table->uuid('kelas');
            $table->uuid('guruMapel')->nullable(true);
            $table->uuid('mapel')->nullable(true);
            $table->enum('semester', ['GENAP', 'GANJIL']);
            $table->foreign('kelas')->references('idKelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('guruMapel')->references('idPegawai')->on('pegawai')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('mapel')->references('idMataPelajaran')->on('mata_pelajaran')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_mapel');
    }
};
