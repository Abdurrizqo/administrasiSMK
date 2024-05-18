<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanPegawai extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'catatan_pegawai';
    protected $primaryKey = 'idCatatanPegawai';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idCatatanPegawai',
        'kategori',
        'keterangan',
        'idPegawai',
    ];
}
