<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenNonAktif extends Model
{
    use HasFactory;

    protected $table = 'instrumen_non_aktif';

    protected $fillable = [
        'tahun_akademik_id',
        'pertanyaan_id',
        'nilai_id',
        'status',
    ];

    // Relasi dengan tabel TahunAkademik (survei_tahun)
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    // Relasi dengan tabel Survei
    public function pertanyaan()
    {
        return $this->belongsTo(Survei::class, 'pertanyaan_id');
    }
    
    public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'nilai_id');
    }
}
