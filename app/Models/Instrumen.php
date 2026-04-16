<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrumen extends Model
{
    use HasFactory;

    protected $table = 'instrumen';

    protected $fillable = [
        'tahun_akademik_id',
        'pertanyaan_id',
        'nilai_id',
        'status',
        'role',
        'akses',
    ];


    public function pertanyaan()
    {
        return $this->hasOne(Pertanyaan::class, 'id', 'pertanyaan_id');
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function survei()
    {
        return $this->belongsTo(Survei::class, 'pertanyaan_id');
    }

    public function instrumenTahunAkademik()
    {
        return $this->hasMany(InstrumenTahunAkademik::class, 'instrumen_id');
    }

    public function nilaiInstrumenMahasiswa()
    {
        return $this->hasMany(NilaiInstrumenMahasiswa::class, 'instrumen_id');
    }
    
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'instrumen_id');
    }

    public function nilaiForPertanyaan()
    {
        return $this->hasMany(Nilai::class, 'instrumen_id', 'id'); 
    }
    
    public function standar()
    {
        return $this->belongsTo(Standar::class, 'standar_id');
    }

    public function chart()
    {
        return $this->hasMany(Chart::class, 'instrumen_id');
    }

}
