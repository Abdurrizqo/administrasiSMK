<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jurusan';
    protected $primaryKey = 'idJurusan';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'namaJurusan',
        'isActive'
    ];
}
