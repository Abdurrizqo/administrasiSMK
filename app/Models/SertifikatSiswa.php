<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatSiswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sertifikat_siswa';
    protected $primaryKey = 'idSertifikatSiswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idSertifikatSiswa',
        'judul',
        'sertifikat',
        'idSiswa',
    ];
}
