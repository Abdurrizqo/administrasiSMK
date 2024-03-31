<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPas extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rekap_pas';

    protected $primaryKey = 'idRekapPas';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'idRekapPas',
        'kelasMapel',
        'siswa',
        'kelas',
        'semester',
        'tahunAjaran',
        'nilaiAkademik',
        'terbilangNilaiAkademik',
        'nilaiKeterampilan',
        'terbilangNilaiKeterampilan',
        'keterangan',
        'status'
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
