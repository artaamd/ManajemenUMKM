<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analitik extends Model
{
    protected $fillable = [
        'konten_id', 'platform', 'likes', 'shares', 'comments', 'engagement_rate', 'grade', 'engagement_filled_at', 'screenshot'
    ];

    protected $dates = ['engagement_filled_at'];

    public function konten()
    {
        return $this->belongsTo(Konten::class);
    }
}