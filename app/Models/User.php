<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'idUser';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'username',
        'password',
        'role',
        'idPegawai',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function dataPegawai(): HasOne
    {
        return $this->hasOne(Pegawai::class, 'idUser', 'idUser');
    }
}
