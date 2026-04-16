<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveiTahunTeks extends Model
{
    use HasFactory;

    protected $table = 'survei_tahun_teks';

    protected $fillable = [
        'tahun_akademik_teks_id',
    ];

    public function tahunAkademikTeks()
    {
        return $this->belongsTo(TahunAkademikTeks::class, 'tahun_akademik_teks_id');
    }

}
