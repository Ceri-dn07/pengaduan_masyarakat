<?php

namespace App\Models;

use App\Models\Pengaduan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Masyarakat extends Authenticatable
{
    use HasFactory;
    protected $table       = "masyarakat";
    protected $primaryKey  = 'nik';
    protected $keyType     = 'string';
    public $incrementing   = false;
    protected $fillable    = [
                                'nik',
                                'nama',
                                'username',
                                'password',
                                'telp'
    ];

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'nik', 'nik');
    }
}
