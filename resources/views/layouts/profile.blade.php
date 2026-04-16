{{-- resources/views/profile.blade.php --}}

@extends('layouts.app')

@section('title', 'Profile')

@section('main')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Halaman -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900">
            @switch(auth()->user()->role)
                @case('admin') Admin Profile @break
                @case('mahasiswa') Profil Mahasiswa @break
                @case('dosen') Profil Dosen @break
                @case('tenaga_kependidikan') Profil Tenaga Kependidikan @break
                @default Profil Pengguna
            @endswitch
        </h1>
        <nav class="flex justify-center mt-2 text-sm text-gray-500" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('profile') }}" class="hover:text-gray-700">Profile</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">Edit</span>
        </nav>
    </div>

    <!-- Notifikasi Sukses atau Error -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-center" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-center" role="alert">
            @if(session('error'))
                <p>{{ session('error') }}</p>
            @endif
            @if ($errors->any())
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Foto Profil -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 text-center">Foto Profil</h2>
                <div class="flex flex-col items-center">
                    <img id="profile-preview" 
                         src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                         alt="Profile Photo" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-sm">
                    
                    <!-- Form Upload Foto -->
                    <form method="POST" action="{{ route('profile.updatePhoto', ['profile' => $user->id]) }}" enctype="multipart/form-data" class="mt-6 w-full">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Pilih Foto Baru</label>
                            <input type="file" id="photo" name="photo" accept="image/*" onchange="previewPhoto()" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                            <i class="fas fa-upload mr-2"></i> Update Foto
                        </button>
                    </form>

                    <!-- Form Hapus Foto -->
                    @if($user->photo)
                    <form method="POST" action="{{ route('profile.deletePhoto', ['profile' => $user->id]) }}" class="mt-4 w-full">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                            <i class="fas fa-trash mr-2"></i> Hapus Foto
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Detail Profil -->
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Detail Profil</h2>
                
                <form method="POST" action="{{ route('profile.update', ['profile' => $user->id]) }}">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" value="{{ $user->email }}" readonly
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-100 sm:text-sm cursor-not-allowed">
                            <p class="mt-1 text-xs text-gray-500">Email tidak dapat diubah.</p>
                        </div>

                        <!-- Input Dinamis Berdasarkan Role -->
                        @if (auth()->user()->role === 'mahasiswa')
                            <div>
                                <label for="npm" class="block text-sm font-medium text-gray-700">NPM</label>
                                <input type="text" id="npm" name="npm" value="{{ old('npm', $user->npm ?? '') }}" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('npm') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                                <input type="text" id="fakultas" name="fakultas" value="{{ old('fakultas', $user->fakultas ?? '') }}" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('fakultas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                                <input type="text" id="prodi" name="prodi" value="{{ old('prodi', $user->prodi ?? '') }}" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('prodi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        @if (auth()->user()->role === 'dosen')
                            <div class="md:col-span-2">
                                <label for="nidn" class="block text-sm font-medium text-gray-700">NIDN</label>
                                <input type="text" id="nidn" name="nidn" value="{{ old('nidn', $user->nidn ?? '') }}" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('nidn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        @if (auth()->user()->role === 'tenaga_kependidikan')
                            <div class="md:col-span-2">
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik ?? '') }}" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('nik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Password -->
                        <div class="relative">
                            <div class="h-20">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru <span class="font-normal text-gray-500">(Kosongkan jika tidak ingin mengubah)</span></label>
                                <div class="relative mt-1">
                                    <input type="password" id="password" name="password"
                                        class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                                        <svg id="password-icon" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="relative">
                            <div class="h-20">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <div class="relative mt-1">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                                        <svg id="password_confirmation-icon" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @error('password_confirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full md:w-auto bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Ganti @push('scripts') dengan script yang lebih modern --}}
@push('scripts')
<script>
    // Fungsi untuk toggle visibility password
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');
        
        if (field.type === "password") {
            field.type = "text";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>`;
        } else {
            field.type = "password";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
        }
    }

    // Fungsi untuk preview foto
    function previewPhoto() {
        const fileInput = document.getElementById('photo');
        const preview = document.getElementById('profile-preview');
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Sembunyikan notifikasi setelah 5 detik
    window.addEventListener('load', () => {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });
</script>
@endpush