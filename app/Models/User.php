<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'handphone',
        'address',
        'photo',
        'npm', 
        'fakultas', 
        'prodi', 
        'nidn', 
        'nik', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke model Role (user belongs to one role)
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role?->name === 'admin';
    }

    /**
     * Cek apakah user adalah user biasa (mahasiswa, dosen, tenaga kependidikan)
     */
    public function isUser()
    {
        return in_array($this->role?->name, ['mahasiswa', 'dosen', 'tenaga_kependidikan']);
    }

    /**
     * Relasi ke nilai instrumen
     */
    public function nilaiInstrumen()
    {
        return $this->hasMany(NilaiInstrumen::class);
    }
    
    public function biodata()
    {
        return $this->hasOne(BiodataResponden::class);
    }
}
