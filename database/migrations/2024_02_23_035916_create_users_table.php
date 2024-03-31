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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('idUser')->primary();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['TU', 'GURU']);
            $table->uuid('idPegawai');
            $table->foreign('idPegawai')->references('idPegawai')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
