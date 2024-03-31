<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'akreditasi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tahunAkreditasi',
        'nilaiAkreditasi',
        'sebutan',
    ];
}
