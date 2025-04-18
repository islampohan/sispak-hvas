<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama', 'deskripsi'];

    public function aturans()
    {
        return $this->belongsToMany(Aturan::class, 'aturan_gejala');
    }

    public function detailKonsultasis()
    {
        return $this->hasMany(DetailKonsultasi::class);
    }
}
