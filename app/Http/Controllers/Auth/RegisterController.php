<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Enums\Role;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }

    public function store(Request $request)
    {

        // Validasi input
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:admin,user,mahasiswa,dosen,tenaga_kependidikan',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tambahkan validasi khusus berdasarkan role
        $validator->after(function ($validator) use ($request) {
            if ($request->role === 'mahasiswa') {
                // Validasi NPM
                if (empty($request->npm)) {
                    $validator->errors()->add('npm', 'Field NPM wajib diisi untuk mahasiswa.');
                } elseif (!preg_match('/^[0-9]{8,15}$/', $request->npm)) {
                    $validator->errors()->add('npm', 'NPM harus berupa angka dengan panjang 8-15 karakter.');
                }
                // Validasi Fakultas
                if (empty($request->fakultas)) {
                    $validator->errors()->add('fakultas', 'Field Fakultas wajib diisi untuk mahasiswa.');
                }
                // Validasi Prodi
                if (empty($request->prodi)) {
                    $validator->errors()->add('prodi', 'Field Prodi wajib diisi untuk mahasiswa.');
                }

            } elseif ($request->role === 'dosen') {
                if (empty($request->nidn)) {
                    $validator->errors()->add('nidn', 'Field NIDN wajib diisi untuk dosen.');
                } elseif (!preg_match('/^[0-9]{10,20}$/', $request->nidn)) {
                    $validator->errors()->add('nidn', 'NIDN harus berupa angka dengan panjang 10-20 karakter.');
                }
                if (empty($request->unit_kerja)) {
                    $validator->errors()->add('unit_kerja', 'Field Unit Kerja wajib diisi untuk dosen.');
                }
            } elseif ($request->role === 'tenaga_kependidikan') {
                if (empty($request->nik)) {
                    $validator->errors()->add('nik', 'Field NIK wajib diisi untuk tenaga kependidikan.');
                } elseif (!preg_match('/^[0-9]{10,20}$/', $request->nik)) {
                    $validator->errors()->add('nik', 'NIK harus berupa angka dengan panjang 10-20 karakter.');
                }
                if (empty($request->unit_kerja)) {
                    $validator->errors()->add('unit_kerja', 'Field Unit Kerja wajib diisi untuk tenaga kependidikan.');
                }
            }
        });

        // Menambahkan aturan validasi khusus berdasarkan role yang dipilih
        $validator->after(function ($validator) use ($request) {
        if ($request->role === Role::Mahasiswa->value) {
            $validator->addRules([
                'npm' => 'required|string|min:8|max:15|unique:users',
                'fakultas' => 'required|string|max:255',
                'prodi' => 'required|string|max:255',
            ]);
        } elseif ($request->role === Role::Dosen->value) {
            $validator->addRules([
                'nidn' => 'required|string|min:10|max:20|unique:users',
                'unit_kerja' => 'required|string|max:255',
            ]);
        } elseif ($request->role === Role::TenagaKependidikan->value) {
            $validator->addRules([
                'nik' => 'required|string|max:20|unique:users',
                'unit_kerja' => 'required|string|max:255',
            ]);
        }
        });

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data pengguna
        $user = User::create([
            'role' => Role::from($request->role)->value, // Gunakan enum untuk memastikan konsistensi
            'name' => $request->name,
            'email' => $request->email,
            'npm' => $request->role === Role::Mahasiswa->value ? $request->npm : null,
            'fakultas' => $request->role === Role::Mahasiswa->value ? $request->fakultas : null,
            'prodi' => $request->role === Role::Mahasiswa->value ? $request->prodi : null,
            'nidn' => $request->role === Role::Dosen->value ? $request->nidn : null,
            'nik' => $request->role === Role::TenagaKependidikan->value ? $request->nik : null,
            'unit_kerja' => in_array($request->role, [Role::Dosen->value, Role::TenagaKependidikan->value]) ? $request->unit_kerja : null,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Verifikasi email langsung
        ]);

        // Login pengguna setelah registrasi berhasil
        auth()->login($user);

        // Redirect ke login atau halaman lainnya
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function storeMahasiswa(Request $request)
    {
        // Validasi dan proses registrasi mahasiswa
        $this->storeUser($request, 'mahasiswa');
    }

    public function storeDosen(Request $request)
    {
        // Validasi dan proses registrasi dosen
        $this->storeUser($request, 'dosen');
    }

    public function storeTenagaKependidikan(Request $request)
    {
        // Validasi dan proses registrasi tenaga kependidikan
        $this->storeUser($request, 'tenaga_kependidikan');
    }

    private function storeUser(Request $request, $role)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Tambahkan validasi khusus jika diperlukan
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $role,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function rules()
    {
        return [
            'role' => ['required', Rule::in(Role::casesValues())],
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'npm' => 'required_if:role,' . Role::MAHASISWA->value . '|string|max:15|unique:users',
            'fakultas' => 'required_if:role,' . Role::MAHASISWA->value . '|string|max:255', 
            'prodi' => 'required_if:role,' . Role::MAHASISWA->value . '|string|max:255',
            'nidn' => 'required_if:role,' . Role::DOSEN->value . '|string|max:20|unique:users',
            'nik' => 'required_if:role,' . Role::TENAGA_KEPENDIDIKAN->value . '|string|max:20|unique:users',
            'unit_kerja' => 'required_if:role,' . Role::DOSEN->value . ',' . Role::TENAGA_KEPENDIDIKAN->value . '|string|max:255', 
        ];
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:mahasiswa,tenaga_kependidikan,dosen'],
            'npm' => $data['role'] === 'mahasiswa' ? ['required', 'string', 'min:8', 'max:15', 'unique:users'] : 'nullable',
            'fakultas' => $data['role'] === 'mahasiswa' ? ['required', 'string', 'max:255'] : 'nullable',
            'prodi' => $data['role'] === 'mahasiswa' ? ['required', 'string', 'max:255'] : 'nullable',
            'nidn' => $data['role'] === 'dosen' ? ['required', 'string', 'max:20', 'unique:users'] : 'nullable',
            'nik' => $data['role'] === 'tenaga_kependidikan' ? ['required', 'string', 'max:20', 'unique:users'] : 'nullable',
            'unit_kerja' => in_array($data['role'], ['dosen', 'tenaga_kependidikan']) ? ['required', 'string', 'max:255'] : 'nullable', 
        ]);
    }
}
