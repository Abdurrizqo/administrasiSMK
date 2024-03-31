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
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'namaSekolah',
        'npsn',
        'nss',
        'namaKepalaSekolah',
        'nipKepalaSekolah',
        'alamat',
        'tahunBerdiri',
        'tahunAjaran',
        'logo',
        'semester',
    ];
}
