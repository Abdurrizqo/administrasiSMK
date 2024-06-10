<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalKegiatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jurnal_kegiatan';
    protected $primaryKey = 'idJurnalKegiatan';
    public $incrementing = false; // Karena UUID bukan auto increment
    protected $keyType = 'string'; // Tipe kunci adalah string

    protected $fillable = [
        'materiKegiatan',
        'Hasil',
        'Hambatan',
        'Solusi',
        'penulisKegiatan',
        'tanggalDibuat'
    ];

}
