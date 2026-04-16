<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AveragePerRoleSheet implements FromCollection, WithHeadings
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
                DB::raw('AVG(n.nilai) as rata_rata')
            )
            ->groupBy('u.role')
            ->get();
    }

    public function headings(): array
    {
        return ['Pengguna', 'Rata-rata Nilai'];
    }
}