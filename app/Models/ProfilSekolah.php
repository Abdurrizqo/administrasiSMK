<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'profile_sekolah';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'namaSekolah',
        'npsn',
        'nss',
        'jenjangPendidikan',
        'namaKepalaSekolah',
        'nipKepalaSekolah',
        'lintang',
        'bujur',
        'alamat',
        'nomerTelfon',
        'email',
        'website',
        'tahunBerdiri',
        'tahunAjaran',
        'logo',
        'semester'
    ];
}
