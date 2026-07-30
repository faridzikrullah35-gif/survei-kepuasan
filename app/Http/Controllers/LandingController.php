<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $slides = Slide::active()->get();

        // Data untuk dropdown filter
        $tahunAkademik = TahunAkademik::where('status', 'Aktif')->get();

        $instrumenUntukDropdown = DB::table('instrumen')
            ->join('pertanyaan as p', 'p.id', '=', 'instrumen.pertanyaan_id')
            ->whereNotNull('p.standar')
            ->select(DB::raw('MIN(instrumen.id) as id'), 'p.standar')
            ->groupBy('p.standar')
            ->orderBy('p.standar')
            ->get();

        $roles = User::whereNotNull('role')
            ->where('role', '!=', 'admin')
            ->distinct()
            ->orderBy('role')
            ->pluck('role');

        // Statistik pengguna (semua user)
        $roleCounts = User::select('role', DB::raw('COUNT(*) as total'))
            ->groupBy('role')
            ->orderBy('role')
            ->get();

        // --- Ambil data untuk chart berdasarkan filter ---
        $tahunAkademikId = $request->input('tahun_akademik_id');
        $standarDipilih  = $request->input('instrumen_id');
        $roleDipilih     = $request->input('role');

        $baseQuery = DB::table('nilai_instrumen_mahasiswa as n')
            ->join('users as u', 'u.id', '=', 'n.user_id')
            ->join('instrumen as i', 'i.id', '=', 'n.instrumen_id')
            ->join('pertanyaan as p', 'p.id', '=', 'i.pertanyaan_id')
            ->join('tahun_akademik as t', 't.id', '=', 'i.tahun_akademik_id')
            ->where('n.status', 'terjawab');

        if ($tahunAkademikId) {
            $baseQuery->where('i.tahun_akademik_id', $tahunAkademikId);
        }

        if ($standarDipilih) {
            $standar = DB::table('instrumen')
                ->join('pertanyaan as p', 'p.id', '=', 'instrumen.pertanyaan_id')
                ->where('instrumen.id', $standarDipilih)
                ->value('p.standar');

            if ($standar) {
                $instrumenIds = DB::table('instrumen')
                    ->join('pertanyaan as p', 'p.id', '=', 'instrumen.pertanyaan_id')
                    ->where('p.standar', $standar)
                    ->pluck('instrumen.id');

                $baseQuery->whereIn('n.instrumen_id', $instrumenIds);
            }
        }

        if ($roleDipilih) {
            $baseQuery->where('u.role', $roleDipilih);
        }

        $nilaiCounts = (clone $baseQuery)
            ->select(
                DB::raw('SUM(n.nilai = 1) as nilai_1'),
                DB::raw('SUM(n.nilai = 2) as nilai_2'),
                DB::raw('SUM(n.nilai = 3) as nilai_3'),
                DB::raw('SUM(n.nilai = 4) as nilai_4')
            )
            ->first();

        if (!$nilaiCounts) {
            $nilaiCounts = (object) ['nilai_1' => 0, 'nilai_2' => 0, 'nilai_3' => 0, 'nilai_4' => 0];
        }

        return view('landing', compact(
            'slides',
            'tahunAkademik',
            'instrumenUntukDropdown',
            'roles',
            'roleCounts',
            'nilaiCounts'
        ));
    }
}