<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMapel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kelas_mapel';

    protected $primaryKey = 'idKelasMapel';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'idKelasMapel',
        'kelas',
        'guruMapel',
        'mapel',
        'tahunAjaran',
        'semester'
    ];

    public function dataKelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas', 'idKelas');
    }

    public function dataGuruMapel()
    {
        return $this->belongsTo(Pegawai::class, 'guruMapel', 'idPegawai');
    }

    public function dataMapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel', 'idMataPelajaran');
    }
}
