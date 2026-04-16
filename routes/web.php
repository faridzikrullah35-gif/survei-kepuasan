<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\SurveiNilaiController;
use App\Http\Controllers\NilaiInstrumenMahasiswaController;
use App\Http\Controllers\InstrumenNonAktifController;
use App\Http\Controllers\PertanyaanTeksController;
use App\Http\Controllers\SurveiTeksController;
use App\Http\Controllers\InstrumenTeksController;
use App\Http\Controllers\NilaiTeksController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\StandarController; 
use App\Http\Controllers\NilaiInstrumenTeksController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\TahunAkademikTeksController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserImportController;
use App\Http\Controllers\KritikSaranController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginMahasiswaController;
use App\Http\Middleware\CheckRole;

use App\Http\Controllers\PdfController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::redirect('/', '/Survei_Kepuasan');

Route::get('/Survei_Kepuasan', function () {
    return view('landing');
});

Route::get('/login', function () {
    return view('pages.auth.auth-login');
})->name('login');

Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth', 'role:user,mahasiswa,dosen,tenaga_kependidikan'])->get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

Route::get('/user/{user}/set-dosen', [UserRoleController::class, 'setRoleToDosen']);
Route::get('/user/{user}/set-mahasiswa', [UserRoleController::class, 'setRoleToMahasiswa']);
Route::get('/user/{user}/set-tenaga', [UserRoleController::class, 'setRoleToTenagaKependidikan']);
Route::get('/user/{user}/check-role', [UserRoleController::class, 'checkUserRole']);

Route::post('/register/mahasiswa', [RegisterController::class, 'storeMahasiswa'])->name('register.mahasiswa');
Route::post('/register/dosen', [RegisterController::class, 'storeDosen'])->name('register.dosen');
Route::post('/register/tenaga_kependidikan', [RegisterController::class, 'storeTenagaKependidikan'])->name('register.tenaga_kependidikan');

Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin,mahasiswa,dosen,tenaga_kependidikan']);

Route::get('/profile', [UserController::class, 'index'])->name('profile')->middleware('auth');

// Route untuk logout
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route dengan middleware `auth` untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('/dashboard', DashboardController::class);
    Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::put('profile/{profile}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/{profile}/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::delete('/profile/{profile}/delete-photo', [UserController::class, 'deletePhoto'])->name('profile.deletePhoto');
    Route::get('/profile', [UserController::class, 'index'])->name('profile.index')->middleware('auth');
    Route::delete('/profile/{profile}/delete-photo', [UserController::class, 'deletePhoto'])
        ->name('profile.deletePhoto')
        ->middleware('auth');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Route yang hanya bisa diakses oleh admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('pertanyaan', PertanyaanController::class);
        Route::resource('tahun_akademik', TahunAkademikController::class);
        Route::resource('nilai', NilaiController::class);
        Route::resource('survei', SurveiController::class);
    });

    Route::get('/instrumen', [InstrumenController::class, 'index'])->middleware('role:admin,user,mahasiswa,dosen,tenaga_kependidikan');
    Route::get('/instrumen', [InstrumenController::class, 'index'])->name('instrumen.index');
    Route::post('/instrumen', [InstrumenController::class, 'store'])->name('instrumen.store');

    // Route tambahan lainnya
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::post('/nilai/store', [NilaiController::class, 'store'])->name('nilai.store');
    Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
    Route::get('/nilai/{id}', [NilaiController::class, 'show']);
    Route::get('/pertanyaan/data', [PertanyaanController::class, 'getData'])->name('pertanyaan.data');
    Route::delete('/tahun_akademik/{tahunAkademik}', [TahunAkademikController::class, 'destroy'])->name('tahun_akademik.destroy');
    Route::get('/nilai/{pertanyaanId}/list', [NilaiController::class, 'list'])->name('nilai.list');
    Route::delete('/nilai/{id}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
    Route::delete('/instrumen/{id}', [InstrumenController::class, 'destroy'])->name('instrumen.destroy');

    Route::post('/survei-nilai/store', [NilaiController::class, 'store'])->name('survei-nilai.store');
    Route::post('/nilai/store', [NilaiController::class, 'store'])->name('nilai.store');

    Route::get('/nilai-instrumen', [NilaiInstrumenController::class, 'index'])->name('nilai_instrumen.index'); 
    Route::post('nilai-instrumen-mahasiswa/store', [NilaiInstrumenMahasiswaController::class, 'store'])
        ->name('nilai-instrumen-mahasiswa.store');
    Route::get('/instrumen/{id}', [InstrumenController::class, 'show'])->name('instrumen.show');
    Route::delete('/instrumen/{id}', [InstrumenController::class, 'destroyInstrumenNonAktif'])->name('instrumen-non-aktif.destroy');
    Route::delete('/instrumen/{id}', [InstrumenController::class, 'destroy'])->name('instrumen.destroy');
    Route::delete('/instrumen', [InstrumenController::class, 'destroyAll'])->name('instrumen.destroyAll');

    Route::get('/instrumen/non-aktif', [InstrumenController::class, 'nonAktif'])->name('instrumen.nonaktif');
    Route::get('/instrumen/non-aktif', [InstrumenController::class, 'indexNonAktif'])->name('instrumen.nonaktif');
    Route::delete('/instrumen-non-aktif/{id}', [InstrumenController::class, 'destroy'])->name('instrumen-non-aktif.destroy');

    Route::post('/instrumen/save-filtered', [InstrumenController::class, 'saveFiltered'])->name('instrumen.saveFiltered');

    Route::get('pertanyaan-teks', [PertanyaanTeksController::class, 'index'])->name('pertanyaan-teks.index');
    Route::get('pertanyaan-teks/create', [PertanyaanTeksController::class, 'create'])->name('pertanyaan-teks.create');
    Route::post('pertanyaan-teks', [PertanyaanTeksController::class, 'store'])->name('pertanyaan-teks.store');
    Route::get('pertanyaan-teks/{id}/edit', [PertanyaanTeksController::class, 'edit'])->name('pertanyaan-teks.edit');
    Route::put('pertanyaan-teks/{id}', [PertanyaanTeksController::class, 'update'])->name('pertanyaan-teks.update');
    Route::delete('pertanyaan-teks/{pertanyaan}', [PertanyaanTeksController::class, 'destroy'])->name('pertanyaan-teks.destroy');

    Route::get('/tahun-akademik-teks', [TahunAkademikTeksController::class, 'index'])->name('tahunAkademik-teks.index');
    Route::get('/tahun-akademik-teks/create', [TahunAkademikTeksController::class, 'create'])->name('tahun_akademik_teks.create');
    Route::post('/tahun-akademik-teks', [TahunAkademikTeksController::class, 'store'])->name('tahun_akademik_teks.store');
    Route::get('/tahun-akademik-teks/{id}/edit', [TahunAkademikTeksController::class, 'edit'])->name('tahunAkademik-teks.edit');
    Route::put('/tahun-akademik-teks/{id}', [TahunAkademikTeksController::class, 'update'])->name('tahunAkademik-teks.update');
    Route::delete('/tahun-akademik-teks/{tahunAkademikTeks}', [TahunAkademikTeksController::class, 'destroy'])->name('tahunAkademik-teks.destroy');

    Route::get('nilai-teks', [NilaiTeksController::class, 'index'])->name('nilai-teks.index');
    Route::post('nilai-teks/store', [NilaiTeksController::class, 'store'])->name('nilai-teks.store');
    Route::delete('nilai-teks/{nilaiTeks}', [NilaiTeksController::class, 'destroy'])->name('nilai-teks.destroy');

    Route::get('survei-teks', [SurveiTeksController::class, 'index'])->name('survei-teks.index');
    Route::post('survei-teks', [SurveiTeksController::class, 'store'])->name('survei-teks.store');

    Route::get('/edit_standar', [StandarController::class, 'edit'])->name('edit-standar.index');
    Route::put('/standar/update-from-table/{kode}', [StandarController::class, 'updateFromTable'])->name('standar.updateFromTable');
    Route::delete('/standar/{kode}', [StandarController::class, 'destroy'])->name('standar.destroy');

    Route::get('instrumen-teks', [InstrumenTeksController::class, 'index'])->name('instrumen_teks.index');
    Route::post('instrumen-teks', [InstrumenTeksController::class, 'store'])->name('instrumen-teks.store');
    Route::get('instrumen_teks', [InstrumenTeksController::class, 'showInstrumenTeksNonaktif'])->name('index.nonaktif');
    Route::delete('/instrumen-teks-non-aktif/{id}', [InstrumenTeksController::class, 'destroyInstrumenTeksNonAktif'])->name('instrumen-teks-non-aktif.destroy');

    Route::post('nilai-instrumen-teks', [NilaiInstrumenTeksController::class, 'store'])->name('nilai_instrumen_teks.store');

    Route::get('/chart', [ChartController::class, 'index'])->name('chart.index');
    Route::get('/chart/instrumen', [ChartController::class, 'getInstrumen'])->name('chart.getInstrumen');
        
    Route::get('/jawaban', [JawabanController::class, 'index'])->name('jawaban.index');

    Route::get('/user-management', [UserManagementController::class, 'index'])->name('usermanagement');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/user-management', [UserManagementController::class, 'store'])->name('usermanagement.store');
    Route::get('users/{id}', [UserManagementController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        
    Route::get('/roles', [RoleController::class, 'index'])->name('role-index.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('role-index.destroy');

    Route::get('/import-users', [UserImportController::class, 'showForm'])->name('showForm');
    Route::post('/import-users', [UserImportController::class, 'import'])->name('users.import');

    Route::get('/survei/{survei}', [InstrumenController::class, 'byStandar'])
        ->middleware('auth')
        ->name('survei.by-standar');
    Route::get('/instrumen-teks/{standar}', [InstrumenTeksController::class, 'byStandar'])
    ->name('instrumen-teks.by-standar');

    Route::get('/chart/export', [ChartController::class, 'export'])->name('chart.export');

    Route::post('/biodata/store', [NilaiInstrumenMahasiswaController::class, 'storeBiodata'])
    ->name('biodata.store');
});



// Route::get('/', function () {

//       return view('pages.app.dashboard-simpadu', ['type_menu'=> '']);

//   });

// Route::get('/login', function () {

//     return view('pages.auth.auth-login');

// })->name('login');
// Route::get('/register', function () {

//       return view('pages.auth.auth-register');

// })->name('register');
// Route::get('/forgot', function () {

//     return view('pages.auth.auth-forgot-password');

// })->name('forgot');
// Route::get('/reset', function () {

//     return view('pages.auth.auth-reset-password');

// })->name('reset');
