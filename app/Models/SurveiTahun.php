<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveiTahun extends Model
{
    use HasFactory;

    protected $table = 'survei_tahun';
    protected $fillable = ['tahun_akademik_id', 'tahun'];

    // Relasi dengan tahun akademik
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function instrumen()
    {
        return $this->hasMany(Instrumen::class, 'tahun_akademik_id');
    }
}
