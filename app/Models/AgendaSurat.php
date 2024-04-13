<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaSurat extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'agenda_surat';
    protected $primaryKey = 'idAgendaSurat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tanggalAgenda',
        'tanggalSurat',
        'statusSurat',
        'nomerSurat',
        'perihal',
        'asalTujuanSurat',
        'dokumenSurat',
        'hasDisposisi'
    ];
}
