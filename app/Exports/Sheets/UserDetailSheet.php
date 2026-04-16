<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserDetailSheet implements FromArray, WithHeadings
{
    protected $instrumenId;
    protected $standar;

    public function __construct($instrumenId = null)
    {
        $this->instrumenId = $instrumenId;

        // Ambil standar jika filter instrumen dipakai
        if ($instrumenId) {
            $this->standar = DB::table('instrumen as i')
                ->join('pertanyaan as p', 'p.id', '=', 'i.pertanyaan_id')
                ->where('i.id', $instrumenId)
                ->value('p.standar');
        }
    }

    /**
     * Ambil semua pertanyaan sesuai standar
     */
    private function getPertanyaanList()
    {
        $query = DB::table('instrumen as i')
            ->join('pertanyaan as p', 'p.id', '=', 'i.pertanyaan_id')
            ->orderBy('p.standar')
            ->orderBy('i.id');

        if ($this->standar) {
            $query->where('p.standar', $this->standar);
        }

        return $query->pluck('p.pertanyaan')->toArray();
    }

    public function array(): array
    {
        $pertanyaanList = $this->getPertanyaanList();

        $query = DB::table('nilai_instrumen_mahasiswa as n')
            ->join('users as u', 'u.id', '=', 'n.user_id')
            ->leftJoin('biodata_responden as b', 'b.user_id', '=', 'u.id')
            ->join('instrumen as i', 'i.id', '=', 'n.instrumen_id')
            ->join('pertanyaan as p', 'p.id', '=', 'i.pertanyaan_id')
            ->join('tahun_akademik as t', 't.id', '=', 'i.tahun_akademik_id')
            ->where('n.status', 'terjawab');

        if ($this->standar) {
            $query->where('p.standar', $this->standar);
        }

        $data = $query
            ->select(
                'n.created_at',
                'u.role',
                'b.fakultas',
                'b.prodi',
                'b.semester',
                'b.homebase',
                'b.fakultas_unit',
                't.tahun',
                'p.standar',
                'p.pertanyaan',
                'n.nilai',
                'n.kritik_saran',
                'n.user_id'
            )
            ->orderBy('n.user_id')
            ->orderBy('p.standar')
            ->orderBy('i.id')
            ->get();

        $result = [];

        // FIX: group user + standar
        $grouped = $data->groupBy(function ($row) {
            return $row->user_id . '_' . $row->standar;
        });

        foreach ($grouped as $rows) {

            $first = $rows->first();

            $row = [
                $first->created_at,
                $first->role
            ];

            // Field sesuai role
            if ($first->role === 'mahasiswa') {

                $row[] = $first->fakultas ?? '-';
                $row[] = $first->prodi ?? '-';
                $row[] = $first->semester ?? '-';
                $row[] = '-';
                $row[] = '-';

            } elseif ($first->role === 'dosen') {

                $row[] = $first->fakultas ?? '-';
                $row[] = $first->homebase ?? '-';
                $row[] = '-';
                $row[] = '-';
                $row[] = '-';

            } else {

                $row[] = $first->fakultas_unit ?? '-';
                $row[] = '-';
                $row[] = '-';
                $row[] = '-';
                $row[] = '-';
            }

            $row[] = $first->tahun;
            $row[] = $first->standar;

            // Mapping pertanyaan -> nilai
            $nilaiMap = $rows->pluck('nilai', 'pertanyaan')->toArray();

            foreach ($pertanyaanList as $pertanyaan) {
                $row[] = $nilaiMap[$pertanyaan] ?? '-';
            }

            $row[] = $first->kritik_saran ?? '-';

            $result[] = $row;
        }

        return $result;
    }

    public function headings(): array
    {
        $pertanyaanList = $this->getPertanyaanList();

        return array_merge([
            'Timestamp',
            'Role/Pengguna',
            'Fakultas',
            'Homebase/Prodi',
            'Semester',
            'Fakultas/Unit',
            'Extra',
            'Tahun Akademik',
            'Standar'
        ], $pertanyaanList, [
            'Saran & Masukan'
        ]);
    }
}