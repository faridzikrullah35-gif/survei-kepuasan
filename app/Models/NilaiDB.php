<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiDB extends Model
{
    use HasFactory;

    protected $table = 'nilai_db';

    protected $fillable = [
        'kode',
        'keterangan',
    ];
}