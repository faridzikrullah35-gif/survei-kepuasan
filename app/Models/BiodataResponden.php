<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiodataResponden extends Model
{
    protected $table = 'biodata_responden';

    protected $fillable = [
        'user_id',
        'role',
        'fakultas',
        'prodi',
        'semester',
        'homebase',
        'fakultas_unit'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}