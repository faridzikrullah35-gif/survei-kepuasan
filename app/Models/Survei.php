<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survei extends Model
{
    use HasFactory;

    protected $table = 'survei';
    
    protected $fillable = [
        'pertanyaan_id', 
        'tahun_akademik_id', 
        'survei_teks_id',
        'standar_id',
        'standar', 
        'pertanyaan',
        'nilai_id',
        'nilai', 
        'keterangan',

    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    // Relasi ke SurveiTahun
    public function surveiTahun()
    {
        return $this->hasMany(SurveiTahun::class);
    }

    public function instrumen()
    {
        return $this->hasMany(Instrumen::class, 'pertanyaan_id');
    }

    public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'nilai_id');
    }

    public function surveiNilai()
    {
        return $this->hasMany(SurveiNilai::class);
    }
 
    public function instrumenNonAktif()
    {
        return $this->hasMany(InstrumenNonAktif::class, 'pertanyaan_id');
    }

    public function pertanyaanteks()
    {
        return $this->belongsToMany(PertanyaanTeks::class, 'survei_pertanyaan', 'survei_id', 'pertanyaan_id');
    }

    public function surveiTeks()
    {
        return $this->hasMany(SurveiTeks::class);
    }

    public function standar()
    {
        return $this->belongsTo(Standar::class, 'standar_id', 'id');
    }
}
