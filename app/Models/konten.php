<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    protected $guarded = [];

    protected $table = 'kontens';

    /**
     * TAMBAHKAN BLOK INI
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_publish' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Analitik (jika ada)
    public function analitik()
    {
        return $this->hasOne(Analitik::class, 'konten_id');
    }
}