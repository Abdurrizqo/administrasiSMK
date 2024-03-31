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
            $table->string('namaKepalaSekolah');
            $table->string('nipKepalaSekolah');
            $table->string('alamat');
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
