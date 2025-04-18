<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kerusakan_id',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kerusakan()
    {
        return $this->belongsTo(Kerusakan::class);
    }

    public function detailKonsultasis()
    {
        return $this->hasMany(DetailKonsultasi::class);
    }
}
