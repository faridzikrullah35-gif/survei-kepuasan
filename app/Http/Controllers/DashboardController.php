<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\InstrumenTeks;
use App\Models\NilaiInstrumenMahasiswa;
use App\Models\NilaiInstrumenTeks;
use App\Models\KritikSaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userRole = $user->role;

        // ===== INSTRUMEN (KUANTITATIF) =====
        if ($userRole === 'admin') {
            $instrumens = Instrumen::with('survei')->get();
        } else {
            $instrumens = Instrumen::with('survei')
                ->where('role', $userRole)
                ->get();
        }

        $totalInstrumen = $instrumens->count();

        // ===== INSTRUMEN TEKS (KUALITATIF) =====
        if ($userRole === 'admin') {
            $instrumenTeks = InstrumenTeks::all();
        } else {
            $instrumenTeks = InstrumenTeks::where('role', $userRole)->get();
        }

        $totalInstrumenTeks = $instrumenTeks->count();

        // ===== STANDAR SURVEI KUALITATIF =====
        $standarSurveiTeks = $instrumenTeks
            ->load('pertanyaanTeks') // pastiin relasi kepanggil
            ->groupBy(fn ($item) => $item->pertanyaanTeks->standar ?? 'Tidak ada standar')
            ->map(function ($group, $standar) {
                return [
                    'standar' => $standar,
                    'jumlah' => $group->count(),
                ];
            });

        $standarSurvei = $instrumens
            ->groupBy(fn ($item) => $item->survei->standar ?? 'Tidak ada standar')
            ->map(function ($group, $standar) {
                return [
                    'standar' => $standar,
                    'jumlah' => $group->count(),
                ];
            });

        // ambil semua KritikSaran untuk standar user
        $standarIds = $instrumens
            ->pluck('pertanyaan.survei')
            ->flatten()
            ->pluck('standar_id')
            ->unique();

        // ===== PROGRES JAWABAN =====
        $userId = Auth::id();

        $totalTerjawab = NilaiInstrumenMahasiswa::where('user_id', $userId)
            ->whereNotNull('nilai')
            ->count();

        $totalKualitatifTerjawab = NilaiInstrumenTeks::where('user_id', $userId)
            ->whereNotNull('jawaban')
            ->count();

        $role = $user->role;

        switch ($role) {
            case 'admin':
                return view('admin.dashboard', compact(
                    'totalInstrumen',
                    'standarSurvei',
                    'totalTerjawab',
                    'instrumens',
                    'totalInstrumenTeks',
                    'totalKualitatifTerjawab'
                ));

            case 'user':
            case 'mahasiswa':
            case 'dosen':
            case 'tenaga_kependidikan':
            case 'alumni':
            case 'dinas':
            case 'masyarakat':
                return view('user.dashboard', compact(
                    'totalInstrumen',
                    'totalInstrumenTeks',
                    'standarSurvei',
                    'standarSurveiTeks',
                    'totalTerjawab',
                    'instrumens',
                    'totalKualitatifTerjawab'
                ));

            default:
                abort(403, 'Unauthorized action.');
        }
    }
}
