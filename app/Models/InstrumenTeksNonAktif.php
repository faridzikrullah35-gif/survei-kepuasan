<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenTeksNonAktif extends Model
{
    use HasFactory;

    protected $table = 'instrumen_teks_non_aktif';

    protected $fillable = [
        'tahun_akademik_teks_id',
        'pertanyaan_teks_id',
        'status',
    ];

    public function tahunAkademikTeks()
    {
        return $this->belongsTo(TahunAkademikTeks::class, 'tahun_akademik_teks_id');
    }

    public function pertanyaanTeks()
    {
        return $this->belongsTo(PertanyaanTeks::class, 'pertanyaan_teks_id');
    }

}
