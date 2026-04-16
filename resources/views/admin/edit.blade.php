@extends('layouts.app')

@section('title', 'Edit User')

{{-- Tidak perlu @push('style') lagi, kita akan menggunakan Tailwind CSS murni --}}

@section('main')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Halaman -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Pengguna</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('usermanagement') }}" class="text-gray-700 hover:text-indigo-600 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Manajemen Pengguna
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-500 md:ml-2">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Tombol Kembali -->
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('usermanagement') }}" class="mb-6 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            @endif
        @endauth
        @if(auth()->user()->role !== 'admin')
            <a href="{{ route('profile') }}" class="mb-6 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        @endif

        <!-- Kartu Formulir -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Formulir Edit Pengguna</h2>
                <p class="text-sm text-gray-600">Perbarui informasi pengguna di bawah ini.</p>
            </div>

            <div class="p-6">
                <!-- Notifikasi Error -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-md bg-red-50 border-l-4 border-red-400">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Ada {{ $errors->count() }} kesalahan yang ditemukan</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Pilihan Role (hanya untuk admin) -->
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role Pengguna</label>
                                <div class="mt-1 space-y-2">
                                    @foreach ($roles as $roleString)
                                        @php $roleData = json_decode($roleString, true); @endphp
                                        @if (is_array($roleData) && isset($roleData['name']))
                                            <div class="flex items-center">
                                                <input id="role_{{ $roleData['name'] }}" name="role" type="radio" value="{{ strtolower($roleData['name']) }}" 
                                                    {{ strtolower($user->role) === strtolower($roleData['name']) ? 'checked' : '' }}
                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                <label for="role_{{ $roleData['name'] }}" class="ml-3 block text-sm font-medium text-gray-700">
                                                    {{ ucwords(str_replace('_', ' ', $roleData['name'])) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endauth

                    <!-- Input Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <div class="mt-1">
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <div class="mt-1">
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Input Password Baru -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                        <div class="mt-1 relative">
                            <input type="password" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah password"
                                class="appearance-none block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" class="toggle-password text-gray-400 hover:text-gray-500 focus:outline-none" data-target="#password">
                                    <span id="password-icon" class="h-5 w-5" aria-hidden="true">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </span>
                                    <span id="password-icon-slash" class="h-5 w-5 hidden" aria-hidden="true">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Input Konfirmasi Password -->
                    <div>
                        <label for="confirm-password" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <div class="mt-1 relative">
                            <input type="password" id="confirm-password" name="password_confirmation" placeholder="Ulangi Password Baru"
                                class="appearance-none block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" class="toggle-password text-gray-400 hover:text-gray-500 focus:outline-none" data-target="#confirm-password">
                                    <span id="confirm-password-icon" class="h-5 w-5" aria-hidden="true">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </span>
                                    <span id="confirm-password-icon-slash" class="h-5 w-5 hidden" aria-hidden="true">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V2"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function () {
            const targetSelector = this.getAttribute('data-target');
            const input = document.querySelector(targetSelector);
            const icon = document.querySelector(targetSelector + '-icon');
            const iconSlash = document.querySelector(targetSelector + '-icon-slash');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.add('hidden');
                iconSlash.classList.remove('hidden');
            } else {
                input.type = 'password';
                icon.classList.remove('hidden');
                iconSlash.classList.add('hidden');
            }
        });
    });
</script>
@endpush