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
        Schema::create('rencana_kegiatan', function (Blueprint $table) {
            $table->uuid('idRencanaKegiatan')->primary();
            $table->date('tanggalMulaiKegiatan');
            $table->date('tanggalSelesaiKegiatan')->nullable(true);
            $table->string('namaKegiatan');
            $table->uuid('ketuaPelaksana');
            $table->foreign('ketuaPelaksana')->references('idPegawai')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->string('wakilKetuaPelaksana')->default('-');
            $table->string('sekretaris')->default('-');
            $table->string('bendahara')->default('-');
            $table->string('dokumenProposal');
            $table->string('dokumenLaporanHasil')->nullable(true);
            $table->boolean('isFinish')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_kegiatan');
    }
};
