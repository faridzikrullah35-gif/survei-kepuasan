<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;


class SurveiNilai extends Model
{
    use HasFactory;

    protected $table = 'survei_nilai';

    protected $fillable = [
        'survei_id',
        'nilai_id',
        'status',
        'keterangan',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    // Relasi ke tabel Survei
    public function survei()
    {
        return $this->belongsTo(Survei::class);
    }

    // Relasi ke tabel Nilai
    public function nilai()
    {
        return $this->belongsTo(Nilai::class);
    }
}
