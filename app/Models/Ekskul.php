<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kelas_ekskul';

    protected $primaryKey = 'idEkskul';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'idKelas',
        'idSiswa',
        'namaEkskul',
        'nilai'
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
