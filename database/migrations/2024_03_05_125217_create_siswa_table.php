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
        Schema::create('siswa', function (Blueprint $table) {
            $table->uuid('idSiswa')->primary();
            $table->string('nis')->unique();
            $table->string('nisn')->unique();
            $table->string('namaSiswa');
            $table->year('tahunMasuk');
            $table->uuid('idJurusan');
            $table->foreign('idJurusan')->references('idJurusan')->on('jurusan')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['aktif', 'pindah', 'lulus'])->default('aktif');
            $table->year('tahunLulus')->nullable(true);
            $table->string('fotoSiswa')->nullable();
            $table->string('nikWali', 28);
            $table->string('namaWali');
            $table->text('alamat');
            $table->enum('hubunganKeluarga', ['Ayah', 'Ibu', 'Kakak', 'Paman', 'Lainnya']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
