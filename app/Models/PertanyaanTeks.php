<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanTeks extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_teks';

    protected $fillable = [
        'standar',
        'pertanyaan',
        
    ];
    
    public function survei()
    {
        return $this->belongsToMany(Survei::class, 'survei_pertanyaan', 'pertanyaan_id', 'survei_id');
    }

    public function surveiTeks()
    {
        return $this->hasMany(SurveiTeks::class, 'pertanyaan_teks_id', 'id');
    }

    public function instrumenTeks()
    {
        return $this->hasMany(InstrumenTeks::class, 'pertanyaan_teks_id');
    }

    public function Jawaban()
    {
        return $this->hasMany(Jawaban::class, 'jawaban_id');
    }

    public function instrumenTeksNonAktif()
    {
        return $this->hasMany(InstrumenTeksNonAktif::class, 'pertanyaan_teks_id');
    }    

}