<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $table = 'chart';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'instrumen_id',
        'tahun_akademik_id',
        'pertanyaan_id',
        'nilai_instrumen_mahasiswa_id',
        'nilai',
    ];

    public function instrumen()
    {
        return $this->belongsTo(Instrumen::class, 'instrumen_id');
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }

    public function nilaiInstrumenMahasiswa()
    {
        return $this->belongsTo(NilaiInstrumenMahasiswa::class, 'nilai_instrumen_mahasiswa_id');
    }

}
