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
        Schema::create('jurnal_kegiatan', function (Blueprint $table) {
            $table->uuid('idJurnalKegiatan')->primary();
            $table->text('materiKegiatan');
            $table->text('Hasil');
            $table->text('Hambatan');
            $table->text('Solusi');
            $table->dateTime('tanggalDibuat');
            $table->uuid('penulisKegiatan');
            $table->foreign('penulisKegiatan')->references('idPegawai')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_kegiatan');
    }
};
