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
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('idKelas')->primary();
            $table->uuid('waliKelas');
            $table->string('namaKelas');
            $table->string('tahunAjaran');
            $table->boolean('isSync')->default(true);
            $table->foreign('waliKelas')->references('idPegawai')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
