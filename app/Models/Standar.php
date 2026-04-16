<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standar extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'standar';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = ['kode', 'nama'];

    public $timestamps = true;

    public function instrumen()
    {
        return $this->hasMany(Instrumen::class, 'standar_id');
    }

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'standar_id');
    }

    public function survei()
    {
        return $this->hasMany(Survei::class, 'standar_id', 'id');
    }

}
