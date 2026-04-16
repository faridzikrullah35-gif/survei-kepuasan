<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAkademik extends Model
{
    use HasFactory;

    protected $table = 'tahun_akademik';
    protected $primarykey = 'id';
    protected $fillable = ['tahun', 'semester', 'status'];

    public function surveiTahun()
    {
        return $this->hasMany(SurveiTahun::class, 'tahun_akademik_id');
    }

    public function instrumen()
    {
        return $this->belongsToMany(Instrumen::class);
    }

    public function instrumenTahunAkademik()
    {
        return $this->hasMany(InstrumenTahunAkademik::class, 'tahun_akademik_id');
    }

    public function nilaiInstrumen()
    {
        return $this->hasMany(NilaiInstrumen::class, 'tahun_akademik_id');
    }
    
    public function instrumenNonAktif()
    {
        return $this->hasMany(InstrumenNonAktif::class, 'tahun_akademik_id');
    }

    public function chart()
    {
        return $this->hasMany(Chart::class, 'tahun_akademik_id');
    }

}