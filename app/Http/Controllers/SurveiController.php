<?php

namespace App\Http\Controllers;
use App\Models\Pertanyaan;
use App\Models\TahunAkademik;
use App\Models\Nilai;
use App\Models\Survei;
use App\Models\SurveiNilai;
use App\Models\SurveiTahun;
use App\Models\Standar;
use App\Models\InstrumenPertanyaan;
use App\Models\InstrumenTahunAkademik;
use App\Models\SurveiTeks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class SurveiController extends Controller
{
    public function index()
    {
        $surveis = Survei::with(['pertanyaan', 'tahunAkademik', 'standar'])->paginate(20);
        $surveiTahun = SurveiTahun::with('tahunAkademik')->get();
        $surveiTeks = SurveiTeks::all();
        $nilaiItems = collect(DB::table('nilai')->get())->groupBy('pertanyaan_id');

        // Tambahkan data roles
        $roles = DB::table('users')->select('role')->distinct()->pluck('role');

        return view('survei.index', compact('surveis', 'surveiTahun', 'nilaiItems', 'roles'));
    }

    public function storeSurvei()
    {
        $nilai = Nilai::where('pertanyaan_id', $pertanyaan->id)->first();

        if ($nilai) {
            Survei::create([
                'standar' => $request->standar,
                'pertanyaan' => $request->pertanyaan,
                'pertanyaan_id' => $pertanyaan->id,
                'nilai_id' => $nilai->id,
            ]);
        } else {
            return redirect()->back()->withErrors('Nilai untuk pertanyaan ini tidak ditemukan.');
        }
    }

}