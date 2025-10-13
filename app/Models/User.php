<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nib',
        'lokasi',
        'akun_facebook',
        'akun_instagram',
        'total_pengikut_facebook',
        'total_pengikut_instagram',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'profile_updated_at' => 'datetime', // <-- TAMBAHKAN BARIS INI
    ];

    public function kontens()
    {
        return $this->hasMany(Konten::class, 'user_id');
    }
}