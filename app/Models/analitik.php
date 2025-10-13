<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analitik extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'konten_id',
        'platform',
        'likes',
        'shares',
        'comments',
        'link_postingan', // <-- Kolom ini ditambahkan
        'engagement_rate',
        'grade',
        'engagement_filled_at',
        'screenshot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'engagement_filled_at' => 'datetime',
    ];

    /**
     * Get the content that owns the analytic.
     */
    public function konten()
    {
        return $this->belongsTo(Konten::class, 'konten_id');
    }
}
