<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'visi_misi';
    protected $primaryKey = 'idVisiMisi';
    protected $fillable = ['konten', 'visiMisi'];
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
}
