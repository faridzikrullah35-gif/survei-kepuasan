<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nilai_id',
        'keterangan',
        'pertanyaan_id',
        
    ];

    public function surveiNilai()
    {
        return $this->hasMany(SurveiNilai::class);
    }
    
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class); 
    }
    
    public function instrumen()
    {
        return $this->belongsTo(Instrumen::class, 'instrumen_id'); 
    }

    public function nilaiInstrumen()
    {
        return $this->hasMany(NilaiInstrumen::class, 'nilai_id');
    }
    
    public function instrumenNonAktif()
    {
        return $this->hasMany(InstrumenNonAktif::class, 'nilai_id');
    }
}