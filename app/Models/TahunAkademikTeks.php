<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademikTeks extends Model
{
    use HasFactory;

    protected $fillable = ['tahun', 'semester', 'status'];

    public function surveiTahunTeks()
    {
        return $this->hasMany(SurveiTahunTeks::class, 'tahun_akademik_teks_id');
    }

    public function instrumenTeks()
    {
        return $this->hasMany(InstrumenTeks::class, 'tahun_akademik_teks_id');
    }
    
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'tahun_akademik_teks_id');
    }

    public function instrumenTeksNonAktif()
    {
        return $this->hasMany(InstrumenTeksNonAktif::class, 'tahun_akademik_teks_id');
    }
    
}
