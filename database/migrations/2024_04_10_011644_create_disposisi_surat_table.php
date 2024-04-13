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
        Schema::create('disposisi_surat', function (Blueprint $table) {
            $table->uuid('idDisposisi')->primary();
            $table->string('judulDisposisi');
            $table->date('tanggalDisposisi');
            $table->longText('arahan');
            $table->uuid('idAgendaSurat');
            $table->uuid('tujuan');
            $table->foreign('idAgendaSurat')->references('idAgendaSurat')->on('agenda_surat')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tujuan')->references('idPegawai')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi_surat');
    }
};
