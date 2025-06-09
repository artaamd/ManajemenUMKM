<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    protected $fillable = [
        'judul', 'platform', 'tanggal_publish', 'durasi', 'status', 'user_id',
    ];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Analitik (jika ada)
    public function analitik()
    {
        return $this->hasOne(Analitik::class, 'konten_id'); // Sesuaikan dengan model Analitik jika ada
    }
}