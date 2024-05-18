<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanSiswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'catatan_siswa';
    protected $primaryKey = 'idCatatanSiswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idCatatanSiswa',
        'kategori',
        'keterangan',
        'idSiswa',
    ];
}
