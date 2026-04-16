<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiInstrumenTeks extends Model
{
    use HasFactory;

    protected $table = 'nilai_instrumen_teks';

    protected $fillable = [
        'instrumen_teks_id',
        'user_id',
        'role',
        'status',
        'jawaban',
    ];

    public function instrumenTeks()
    {
        return $this->belongsTo(InstrumenTeks::class, 'instrumen_teks_id');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
