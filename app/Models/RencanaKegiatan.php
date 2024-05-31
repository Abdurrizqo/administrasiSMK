<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaKegiatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rencana_kegiatan';

    // Primary key yang berupa UUID
    protected $primaryKey = 'idRencanaKegiatan';
    public $incrementing = false;
    protected $keyType = 'string';

    // Properti yang dapat diisi
    protected $fillable = [
        'idRencanaKegiatan',
        'tanggalMulaiKegiatan',
        'tanggalSelesaiKegiatan',
        'namaKegiatan',
        'ketuaPelaksana',
        'wakilKetuaPelaksana',
        'sekretaris',
        'bendahara',
        'dokumenProposal',
        'dokumenLaporanHasil',
        'isFinish'
    ];
}
