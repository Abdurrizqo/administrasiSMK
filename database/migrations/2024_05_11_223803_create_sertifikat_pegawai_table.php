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
        Schema::create('sertifikat_pegawai', function (Blueprint $table) {
            $table->uuid('idSertifikatGuru')->primary();
            $table->string('judul');
            $table->string('sertifikat');
            $table->uuid('idPegawai');
            $table->foreign('idPegawai')->references('idPegawai')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_pegawai');
    }
};
