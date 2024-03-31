<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pegawai extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai';

    protected $primaryKey = 'idPegawai';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nipy',
        'namaPegawai',
        'status',
        'idUser'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'idUser', 'idUser');
    }
}
