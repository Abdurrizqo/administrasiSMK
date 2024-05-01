<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelengkapSekolah extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pelengkap_sekolah';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'skPendirian',
        'tanggalSk',
        'skIzin',
        'tanggalSkIzin',
        'rekening',
        'noRekening',
        'atasNamaRekening'
    ];
}
