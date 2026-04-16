<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveiTeks extends Model
{
    use HasFactory;

    protected $fillable = [
        'pertanyaan_teks_id',
        'standar',
        'pertanyaan',
    ];

    public function pertanyaanTeks()
    {
        return $this->belongsTo(PertanyaanTeks::class, 'pertanyaan_teks_id', 'id');
    }

    public function survei()
    {
        return $this->belongsTo(Survei::class);
    }
}
