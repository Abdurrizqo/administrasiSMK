<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kelas_siswa';
    protected $primaryKey = 'idKelasSiswa';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'idKelas',
        'idSiswa',
        'status',
        'totalHadirGanjil',
        'totalSakitGanjil',
        'totalTanpaKeteranganGanjil',
        'totalIzinGanjil',
        'totalHadirGenap',
        'totalSakitGenap',
        'totalTanpaKeteranganGenap',
        'totalIzinGenap',
        'keteranganAkhirGanjilPTS',
        'keteranganAkhirGanjilPAS',
        'keteranganAkhirGenapPTS',
        'keteranganAkhirGenapPAS',
        'raportGanjil',
        'raportGenap'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'idKelas', 'idKelas');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'idSiswa', 'idSiswa');
    }
}
