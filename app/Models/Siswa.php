<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'siswa';
    protected $primaryKey = 'idSiswa';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'nis',
        'nisn',
        'namaSiswa',
        'tahunMasuk',
        'tahunLulus',
        'idJurusan',
        'status',
        'tahunPindah',
        'fotoSiswa',
        'nikWali',
        'namaWali',
        'alamat',
        'hubunganKeluarga'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'idJurusan', 'idJurusan');
    }
}
