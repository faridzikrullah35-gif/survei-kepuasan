<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
    protected $primarykey = 'id';
    protected $fillable = ['standar', 'pertanyaan', 'standar_id'];
    
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'pertanyaan_id', 'id');
    }

    public function survei()
    {
        return $this->hasMany(Survei::class);
    }

    public function instrumen()
    {
        return $this->hasMany(Instrumen::class, 'pertanyaan_id');
    }

    public function nilaiInstrumen()
    {
        return $this->hasMany(NilaiInstrumen::class, 'pertanyaan_id');
    }

    public function standar()
    {
        return $this->belongsTo(Standar::class, 'standar_id');
    }

    public function chart()
    {
        return $this->hasMany(Chart::class, 'pertanyaan_id');
    }

    public function kritikSarans()
    {
        return $this->hasMany(KritikSaran::class);
    }
}
