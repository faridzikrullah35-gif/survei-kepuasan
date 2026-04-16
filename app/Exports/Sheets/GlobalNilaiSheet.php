<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GlobalNilaiSheet implements FromCollection, WithHeadings
{
    protected $instrumenId;

    public function __construct($instrumenId)
    {
        $this->instrumenId = $instrumenId;
    }

    public function collection()
    {
        return DB::table('nilai_instrumen_mahasiswa as n')
            ->join('instrumen as i', 'n.instrumen_id', '=', 'i.id')
            ->join('pertanyaan as p', 'i.pertanyaan_id', '=', 'p.id')
            ->join('tahun_akademik as t', 'i.tahun_akademik_id', '=', 't.id')
            ->where('n.status', 'terjawab')
            ->when($this->instrumenId, fn($q) =>
                $q->where('n.instrumen_id', $this->instrumenId)
            )
            ->select(
                't.tahun as tahun_akademik',
                'p.standar',
                'p.pertanyaan',
                DB::raw('AVG(n.nilai) as rata_rata'),
                DB::raw('COUNT(*) as total_respon')
            )
            ->groupBy('t.tahun', 'p.standar', 'p.pertanyaan')
            ->get();
    }

    public function headings(): array
    {
        return ['Tahun Akademik', 'Standar', 'Pertanyaan', 'Rata-rata Nilai', 'Total Respon'];
    }
}