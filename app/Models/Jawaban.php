<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawaban';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'instrumen_teks_id',
        'tahun_akademik_teks_id',
        'pertanyaan_teks_id',
        'nilai_instrumen_teks_id',
        'tahun',
        'standar',
        'pertanyaan',
        'jawaban',
    ];

    /**
     * Relasi ke model User (jika diperlukan).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model NilaiInstrumenTeks (jika diperlukan).
     */
    public function nilaiInstrumenTeks()
    {
        return $this->belongsTo(NilaiInstrumenTeks::class);
    }

    /**
     * Relasi ke model InstrumenTeks (jika diperlukan).
     */
    public function instrumenTeks()
    {
        return $this->belongsTo(InstrumenTeks::class, 'instrumen_teks_id');
    }

    public function pertanyaanTeks()
    {
        return $this->belongsTo(PertanyaanTeks::class, 'pertanyaan_teks_id');
    }
    
    public function tahunAkademikTeks()
    {
        return $this->belongsTo(TahunAkademikTeks::class, 'tahun_akademik_teks_id');
    }
}
