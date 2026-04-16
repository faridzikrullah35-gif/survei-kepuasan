<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenTeks extends Model
{
    use HasFactory;

    protected $fillable = [
        'pertanyaan_teks_id',
        'tahun_akademik_teks_id',
        'status',
        'role',
    ];

    public function pertanyaanTeks()
    {
        return $this->belongsTo(PertanyaanTeks::class, 'pertanyaan_teks_id');
    }

    public function tahunAkademikTeks()
    {
        return $this->belongsTo(TahunAkademikTeks::class, 'tahun_akademik_teks_id');
    }

    public function nilaiInstrumenTeks()
    {
        return $this->hasMany(NilaiInstrumenTeks::class, 'instrumen_teks_id');
    }
}
