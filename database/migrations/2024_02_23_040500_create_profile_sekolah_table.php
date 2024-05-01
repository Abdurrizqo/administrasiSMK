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
        Schema::create('profile_sekolah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaSekolah');
            $table->string('npsn');
            $table->string('nss');
            $table->enum('jenjangPendidikan', ['TK', 'SD', 'SMP', 'SMA', 'SMK']);
            $table->string('namaKepalaSekolah');
            $table->string('nipKepalaSekolah');
            $table->string('lintang')->nullable(true);
            $table->string('bujur')->nullable(true);
            $table->text('alamat');
            $table->string('nomerTelfon')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('website')->nullable(true);
            $table->string('tahunBerdiri');
            $table->string('tahunAjaran');
            $table->string('logo')->nullable(true);
            $table->enum('semester', ['GENAP', 'GANJIL']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_sekolah');
    }
};
