<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jadwal extends Model
{
    protected $fillable = ['konten_id', 'tanggal_posting', 'status'];

    public function konten()
    {
        return $this->belongsTo(Konten::class);
    }
}