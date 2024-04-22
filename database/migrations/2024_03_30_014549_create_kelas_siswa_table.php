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
            $table->enum('status', ['NAIK KELAS', 'TINGGAL KELAS'])->nullable(true);

            $table->integer('totalHadirGanjil')->default(0);
            $table->integer('totalSakitGanjil')->default(0);
            $table->integer('totalTanpaKeteranganGanjil')->default(0);
            $table->integer('totalIzinGanjil')->default(0);

            $table->integer('totalHadirGenap')->default(0);
            $table->integer('totalSakitGenap')->default(0);
            $table->integer('totalTanpaKeteranganGenap')->default(0);
            $table->integer('totalIzinGenap')->default(0);

            $table->longText('keteranganAkhirGanjilPTS')->nullable(true);
            $table->longText('keteranganAkhirGanjilPAS')->nullable(true);

            $table->longText('keteranganAkhirGenapPTS')->nullable(true);
            $table->longText('keteranganAkhirGenapPAS')->nullable(true);

            $table->string('raportGanjil')->nullable(true);
            $table->string('raportGenap')->nullable(true);

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
