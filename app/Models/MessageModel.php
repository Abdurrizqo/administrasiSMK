<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'messages';
    protected $primaryKey = 'idMessage';
    public $incrementing = false;
    protected $fillable = [
        'message', 'idDisposisi', 'pegawai', 'file'
    ];
}
