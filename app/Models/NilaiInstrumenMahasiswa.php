<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class NilaiInstrumenMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_instrumen_mahasiswa';
    protected $fillable = [
        'user_id',
        'role',
        'instrumen_id',
        'nilai',
        'keterangan',
        'kritik_saran',
        'status'
    ];
    protected $casts = [
        'nilai' => 'integer',
    ];

    // Relasi dengan tabel Instrumen
    public function instrumen()
    {
        return $this->belongsTo(Instrumen::class, 'instrumen_id');
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chart()
    {
        return $this->hasMany(Chart::class, 'nilai_instrumen_mahasiswa_id');
    }

}
