<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\NilaiInstrumenMahasiswa;
use App\Models\BiodataResponden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiInstrumenMahasiswaController extends Controller
{
    /**
     * Tampilkan data instrumen dengan nilai instrumen mahasiswa.
     */
    public function index()
    {
        // Kode ini sudah bagus, tidak perlu diubah
        $user_id = Auth::id(); 

        $instrumens = Instrumen::with(['nilaiInstrumenMahasiswa' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }])->get();

        return view('instrumen.index', compact('instrumens'));
    }

    /**
     * Simpan atau perbarui data ke tabel nilai_instrumen_mahasiswa.
     */
    /**
     * Simpan atau perbarui data ke tabel nilai_instrumen_mahasiswa.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'nilai' => 'required|array',
                // Validasi key untuk memastikan itu adalah ID yang ada di tabel instrumens
                'nilai.*' => 'required|integer|in:1,2,3,4', 
                'kritik_saran' => 'nullable|string'
            ]);

            $userId = Auth::id();
            $userRole = Auth::user()->role;
            $kritikSaran = $request->kritik_saran;

            // Perbaikan: Loop langsung menggunakan instrumen_id dari request
            foreach ($request->nilai as $instrumenId => $nilai) {
                
                // Sekarang kita tidak perlu query lagi di dalam loop!
                NilaiInstrumenMahasiswa::updateOrCreate(
                    // Kondisi unik untuk mencari data
                    [
                        'user_id'      => $userId,
                        'instrumen_id' => $instrumenId, // Langsung gunakan key dari request
                    ],
                    // Data yang akan diupdate atau dibuat
                    [
                        'role'          => $userRole,
                        'nilai'         => (int) $nilai,
                        'keterangan'    => $this->getKeterangan($nilai), // Gunakan helper method
                        'kritik_saran'  => $kritikSaran,
                        'status'        => 'terjawab'
                    ]
                );
            }

            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Saat development, tampilkan error lengkap. Saat production, log saja.
            if (config('app.env') !== 'production') {
                return response()->json([
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
            
            return response()->json(['error' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    private function getKeterangan($nilai)
    {
        return match ($nilai) {
            4 => 'Sangat Baik',
            3 => 'Baik',
            2 => 'Kurang',
            1 => 'Sangat Kurang',
            default => 'Tidak Ada Keterangan'
        };
    }

    public function storeBiodata(Request $request)
    {
        // Kode ini sudah benar menggunakan updateOrCreate, tidak perlu diubah
        $user = auth()->user();

        if ($user->role === 'mahasiswa') {
            $request->validate([
                'fakultas' => 'required|string|max:255',
                'prodi' => 'required|string|max:255',
                'semester' => 'required|string|max:50',
            ]);
        } elseif ($user->role === 'dosen') {
            $request->validate([
                'fakultas' => 'required|string|max:255',
                'homebase' => 'required|string|max:255',
            ]);
        } elseif ($user->role === 'tenaga_kependidikan') {
            $request->validate([
                'fakultas_unit' => 'required|string|max:255',
            ]);
        }

        \App\Models\BiodataResponden::updateOrCreate(
            ['user_id' => $user->id],
            [
                'role' => $user->role,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
                'semester' => $request->semester,
                'homebase' => $request->homebase,
                'fakultas_unit' => $request->fakultas_unit
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Biodata berhasil disimpan'
        ]);
    }
}