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
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid('idMessage')->primary();
            $table->longText('message')->nullable(true);
            $table->longText('file')->nullable(true);
            $table->uuid('pegawai');
            $table->uuid('idDisposisi');
            $table->foreign('pegawai')->references('idPegawai')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idDisposisi')->references('idDisposisi')->on('disposisi_surat')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
