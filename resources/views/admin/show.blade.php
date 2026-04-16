@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('main')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Halaman -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Detail Pengguna</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('usermanagement') }}" class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">Manajemen Pengguna</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-500 md:ml-2">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Kartu Utama -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Header Kartu -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Informasi Lengkap Pengguna</h2>
                <p class="text-indigo-100">Berikut adalah detail lengkap dari pengguna yang dipilih.</p>
            </div>

            <!-- Body Kartu -->
            <div class="p-6 md:p-8">
                <!-- Profil Avatar dan Nama (Opsional, tapi menambah sentuhan modern) -->
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-2xl font-bold text-indigo-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-500">{{ $user->role }}</p>
                    </div>
                </div>

                <!-- Tabel Detail -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
                    </div>
                    <div class="border-b border-gray-200 pb-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Alamat Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                    </div>
                    <div class="border-b border-gray-200 pb-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Password</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3"></circle>
                                </svg>
                                Tersimpan Terenkripsi
                            </span>
                        </dd>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Role / Peran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                {{ ucwords(preg_replace('/([a-z])([A-Z])/', '$1 $2', $user->role)) }}
                            </span>
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Footer Kartu -->
            <div class="bg-gray-50 px-6 py-3 flex justify-end">
                <a href="{{ route('usermanagement') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <!-- Ikon Panah Kiri -->
                    <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection