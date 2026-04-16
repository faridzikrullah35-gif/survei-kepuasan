@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

    <!--====== Favicon Icon ======-->
    <link
        rel="shortcut icon"
        href="assets/images/favicon.png"
        type="image/png"
        />

    <style>
        /* Latar belakang halaman */
        body {
            background-image: url('{{ asset('img/background.jpg') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        /* Media query untuk layar besar */
        @media only screen and (min-width: 1200px) {
            body {
                background-image: url('{{ asset('img/background.jpg') }}');
            }
        }

        /* Card styling */
        .card {
            background-color: #ffffff; /* Warna solid */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan opsional */
            border-radius: 10px; /* Sudut melengkung */
            padding: 20px; /* Jarak dalam */
            border: 1px solid #ddd; /* Border tipis */
        }
    </style>
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="form-group">
                    <label for="role">Jenis Pengguna</label>
                    <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                        <option value="" selected>Pilih Peran Pengguna</option>
                        <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="tenaga_kependidikan" {{ old('role') == 'tenaga_kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group" id="npm-group" style="display: none;">
                    <label for="npm">NPM</label>
                    <input id="npm" type="text"
                        class="form-control @error('npm') is-invalid @enderror"
                        name="npm" value="{{ old('npm') }}" autofocus>
                    @error('npm')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <!-- Input untuk Fakultas -->
                <div class="form-group" id="fakultas-group" style="display: none;">
                    <label for="fakultas">Fakultas</label>
                    <input id="fakultas" type="text"
                        class="form-control @error('fakultas') is-invalid @enderror"
                        name="fakultas" value="{{ old('fakultas') }}" autofocus>
                    @error('fakultas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <!-- Input untuk Prodi -->
                <div class="form-group" id="prodi-group" style="display: none;">
                    <label for="prodi">Prodi</label>
                    <input id="prodi" type="text"
                        class="form-control @error('prodi') is-invalid @enderror"
                        name="prodi" value="{{ old('prodi') }}" autofocus>
                    @error('prodi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group" id="nidn-group" style="display: none;">
                    <label for="nidn">NIDN</label>
                    <input id="nidn" type="text" 
                        class="form-control @error('nidn') is-invalid @enderror" 
                        name="nidn" value="{{ old('nidn') }}" autofocus>
                    @error('nidn')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group" id="unit-kerja-group" style="display: none;">
                    <label for="unit_kerja">Unit Kerja</label>
                    <input id="unit_kerja" type="text" 
                        class="form-control @error('unit_kerja') is-invalid @enderror" 
                        name="unit_kerja" value="{{ old('unit_kerja') }}">
                    @error('unit_kerja')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group" id="nik-group" style="display: none;">
                    <label for="nik">NIK</label>
                    <input id="nik" type="text" 
                        class="form-control @error('nik') is-invalid @enderror" 
                        name="nik" value="{{ old('nik') }}" autofocus>
                    @error('nik')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                    <div class="form-group">
                        <label for="password" class="d-block">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                name="password">
                            <button type="button" class="btn btn-outline-secondary toggle-password border-0" data-target="#password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="d-block">Password Confirmation</label>
                        <div class="input-group">
                            <input id="password_confirmation" type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation">
                            <button type="button" class="btn btn-outline-secondary toggle-password border-0" data-target="#password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                <div class="form-group">
                    <button type="submit" id="submitButton" class="btn btn-primary btn-lg btn-block" role="button">
                        Register
                    </button>
                </div>
            </form>

            <div class="form-group">
                <a href="{{ route('login') }}" class="btn btn-danger btn-lg btn-block">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');

            togglePasswordButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetInput = document.querySelector(this.getAttribute('data-target'));
                    const icon = this.querySelector('i');
                    
                    // Toggles the password field visibility and changes the icon
                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        targetInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen-elemen yang diperlukan
    const roleSelect = document.getElementById('role');
    const nimGroup = document.getElementById('npm-group');
    const nidnGroup = document.getElementById('nidn-group');
    const nikGroup = document.getElementById('nik-group');
    const fakultasGroup = document.getElementById('fakultas-group');
    const prodiGroup = document.getElementById('prodi-group');
    const unitKerjaGroup = document.getElementById('unit-kerja-group');
    const submitButton = document.getElementById('submitButton');

    // Fungsi untuk mengatur visibilitas grup input dan teks tombol
    function updateFieldsAndButton(role) {
        // Sembunyikan semua grup input terlebih dahulu
        nimGroup.style.display = 'none';
        nidnGroup.style.display = 'none';
        nikGroup.style.display = 'none';
        fakultasGroup.style.display = 'none';
        prodiGroup.style.display = 'none';
        unitKerjaGroup.style.display = 'none'; // Tambahkan sembunyikan unit kerja

        // Tampilkan grup input sesuai dengan role
        if (role === 'mahasiswa') {
            nimGroup.style.display = 'block';
            fakultasGroup.style.display = 'block';
            prodiGroup.style.display = 'block';
            submitButton.textContent = 'Register Mahasiswa';
        } else if (role === 'dosen') {
            nidnGroup.style.display = 'block';
            unitKerjaGroup.style.display = 'block'; // Tampilkan unit kerja untuk dosen
            submitButton.textContent = 'Register Dosen';
        } else if (role === 'tenaga_kependidikan') {
            nikGroup.style.display = 'block';
            unitKerjaGroup.style.display = 'block'; // Tampilkan unit kerja untuk tenaga kependidikan
            submitButton.textContent = 'Register Tenaga Kependidikan';
        } else {
            submitButton.textContent = 'Register'; // Default teks tombol
        }
    }

    // Panggil fungsi saat halaman pertama kali dimuat
    updateFieldsAndButton(roleSelect.value);

    // Tambahkan event listener untuk perubahan dropdown role
    roleSelect.addEventListener('change', function () {
        updateFieldsAndButton(this.value);
    });
});
</script>

@endpush
