<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKerusakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kerusakan_id',
        'komponen',
        'tanggal_kerusakan',
        'tanggal_perbaikan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_kerusakan' => 'datetime',
        'tanggal_perbaikan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kerusakan()
    {
        return $this->belongsTo(Kerusakan::class);
    }
}
