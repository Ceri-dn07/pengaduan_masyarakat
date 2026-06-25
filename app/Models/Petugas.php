<?php

namespace App\Models;

use App\Models\Tanggapan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    use HasFactory;
    protected $table       = "petugas";
    protected $primaryKey  = 'id_petugas';
    protected $keyType     = 'integer';
    public $incrementing   = true;
    protected $fillable    = [
                                'id_petugas',
                                'nama_petugas',
                                'username',
                                'password',
                                'telp',
                                'level'
    ];

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'id_petugas', 'id_petugas');
    }
}
