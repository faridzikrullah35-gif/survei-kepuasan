<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SummaryPerRoleSheet implements FromCollection, WithHeadings
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
            ->where('n.status', 'terjawab')
            ->when($this->instrumenId, fn($q) => 
                $q->where('n.instrumen_id', $this->instrumenId)
            )
            ->select(
                'u.role',
                DB::raw('SUM(n.nilai = 1) as nilai_1'),
                DB::raw('SUM(n.nilai = 2) as nilai_2'),
                DB::raw('SUM(n.nilai = 3) as nilai_3'),
                DB::raw('SUM(n.nilai = 4) as nilai_4'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('u.role')
            ->get();
    }

    public function headings(): array
    {
        return ['Pengguna', 'Nilai 1', 'Nilai 2', 'Nilai 3', 'Nilai 4', 'Total'];
    }
}