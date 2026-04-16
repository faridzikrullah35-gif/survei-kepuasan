<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailSheet implements FromCollection, WithHeadings
{
    protected $instrumenId;

    public function __construct($instrumenId)
    {
        $this->instrumenId = $instrumenId;
    }

    public function collection()
    {
        return DB::table('nilai_instrumen_mahasiswa as n')
            ->join('users as u', 'u.id', '=', 'n.user_id')
            ->join('instrumen as i', 'n.instrumen_id', '=', 'i.id')
            ->join('pertanyaan as p', 'i.pertanyaan_id', '=', 'p.id')
            ->join('tahun_akademik as t', 'i.tahun_akademik_id', '=', 't.id')
            ->where('n.status', 'terjawab')
            ->when($this->instrumenId, fn($q) =>
                $q->where('n.instrumen_id', $this->instrumenId)
            )
            ->select(
                'u.role',
                't.tahun as tahun_akademik',
                'p.standar',
                'p.pertanyaan',
                'n.nilai'
            )
            ->get();
    }

    public function headings(): array
    {
        return ['Pengguna', 'Tahun Akademik', 'Standar', 'Pertanyaan', 'Nilai'];
    }
}