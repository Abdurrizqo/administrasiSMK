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
        Schema::create('pelengkap_sekolah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('skPendirian')->nullable(true);
            $table->date('tanggalSk')->nullable(true);
            $table->string('skIzin')->nullable(true);
            $table->date('tanggalSkIzin')->nullable(true);
            $table->string('rekening')->nullable();
            $table->string('noRekening')->nullable();
            $table->string('atasNamaRekening')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelengkap_sekolah');
    }
};
