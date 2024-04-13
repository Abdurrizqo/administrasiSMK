<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposisiSurat extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'disposisi_surat';
    protected $primaryKey = 'idDisposisi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'judulDisposisi',
        'idAgendaSurat',
        'tanggalDisposisi',
        'arahan',
        'tujuan',
    ];
}
