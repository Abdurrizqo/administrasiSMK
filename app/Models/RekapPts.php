<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPts extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rekap_pts';

    protected $primaryKey = 'idRekapPts';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'idRekapPts',
        'kelasMapel',
        'kelas',
        'siswa',
        'semester',
        'tahunAjaran',
        'nilaiAkademik',
        'terbilangNilaiAkademik',
        'nilaiKeterampilan',
        'terbilangNilaiKeterampilan',
        'keterangan'
    ];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class, 'kelasMapel', 'idKelasMapel');
    }

    public function dataSiswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa', 'idSiswa');
    }
}
