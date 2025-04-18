<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama', 'deskripsi'];

    public function aturans()
    {
        return $this->hasMany(Aturan::class);
    }

    public function solusis()
    {
        return $this->hasMany(Solusi::class);
    }

    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class);
    }

    public function riwayatKerusakans()
    {
        return $this->hasMany(RiwayatKerusakan::class);
    }
}
