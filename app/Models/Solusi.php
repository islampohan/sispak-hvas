<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solusi extends Model
{
    use HasFactory;

    protected $fillable = ['kerusakan_id', 'deskripsi', 'langkah_perbaikan'];

    public function kerusakan()
    {
        return $this->belongsTo(Kerusakan::class);
    }
}
