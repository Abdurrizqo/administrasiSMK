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
        Schema::create('agenda_surat', function (Blueprint $table) {
            $table->uuid('idAgendaSurat')->primary();
            $table->date('tanggalAgenda');
            $table->date('tanggalSurat');
            $table->enum('statusSurat', ['MASUK', 'KELUAR']);
            $table->string('nomerSurat');
            $table->longText('perihal');
            $table->string('asalTujuanSurat');
            $table->string('dokumenSurat');
            $table->boolean('hasDisposisi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_surat');
    }
};
