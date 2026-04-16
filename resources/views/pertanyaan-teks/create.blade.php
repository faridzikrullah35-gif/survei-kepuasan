@extends('layouts.app')

@section('title', 'Create Pertanyaan')

@push('style')
    <!-- Jika memerlukan library CSS khusus untuk halaman ini, letakkan di sini -->
    <!-- <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}"> -->
@endpush

@section('main')
<div class="main-content bg-gray-50 p-4 md:p-6 lg:p-8">
    <section class="section">
        <!-- Header Section -->
        <div class="bg-white shadow-sm p-4 md:p-6 mb-6 rounded-lg">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">Survei Kualitatif</h1>
            <div class="flex text-sm mt-2 text-gray-600" aria-label="Breadcrumb">
                <a href="{{ route('pertanyaan-teks.index') }}" class="text-blue-600 hover:underline">Survei Kualitatif</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700">Tambahkan Survei Kualitatif</span>
            </div>
        </div>

        <!-- Body Section -->
        <div class="section-body">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-6">Tambah Survei Kualitatif</h2>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 md:p-6 border-b border-gray-200">
                    <h4 class="text-base md:text-lg font-medium text-gray-800">Isi Survei Kualitatif Baru</h4>
                </div>
                
                <div class="p-4 md:p-6">
                    <form action="{{ route('pertanyaan-teks.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Input Standar -->
                        <div>
                            <label for="standar" class="block text-sm font-medium text-gray-700 mb-2">
                                Standar
                            </label>
                            <input type="text" 
                                   name="standar" 
                                   id="standar" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                   placeholder="Masukkan standar" 
                                   required>
                        </div>

                        <!-- Input Pertanyaan -->
                        <div>
                            <label for="pertanyaan" class="block text-sm font-medium text-gray-700 mb-2">
                                Pertanyaan
                            </label>
                            <input type="text" 
                                   name="pertanyaan" 
                                   id="pertanyaan" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                   placeholder="Masukkan pertanyaan" 
                                   required>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-center justify-end">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-2"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pesan Sukses -->
            @if(session('success'))
                <div class="mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mx-auto text-center text-sm md:text-base max-w-lg">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- Jika memerlukan library JS khusus untuk halaman ini, letakkan di sini -->
    <!-- Kode Bootstrap JS tidak lagi diperlukan karena tidak ada komponen Bootstrap yang digunakan -->
@endpush