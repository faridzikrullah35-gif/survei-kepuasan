@extends('layouts.app')

@section('title', 'Edit Tahun Akademik Kualitatif')

@push('style')
    <!-- CSS selectric tidak digunakan dalam form ini, jadi bisa dihapus atau dikomentari -->
    <!-- <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}"> -->
@endpush

@section('main')
<div class="main-content bg-gray-50 p-4 md:p-6 lg:p-8">
    <section class="section">
        <!-- Header Section -->
        <div class="bg-white shadow-sm p-4 md:p-6 mb-6 rounded-lg">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">Edit Tahun Akademik Kualitatif</h1>
            <div class="flex text-sm mt-2 text-gray-600" aria-label="Breadcrumb">
                <a href="{{ route('tahunAkademik-teks.index') }}" class="text-blue-600 hover:underline">Tahun Akademik Kualitatif</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700">Edit Tahun Akademik Kualitatif</span>
            </div>
        </div>

        <!-- Body Section -->
        <div class="section-body">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-6">Edit Tahun Akademik Kualitatif</h2>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 md:p-6 border-b border-gray-200">
                    <h4 class="text-base md:text-lg font-medium text-gray-800">Edit Tahun Akademik Kualitatif</h4>
                </div>
                
                <div class="p-4 md:p-6">
                    <form action="{{ route('tahunAkademik-teks.update', $tahunAkademikTeks->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Input Tahun Akademik -->
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Akademik
                            </label>
                            <input type="text" 
                                   id="tahun" 
                                   name="tahun" 
                                   value="{{ old('tahun', $tahunAkademikTeks->tahun) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                   placeholder="Contoh: 2023/2024" 
                                   required>
                            @error('tahun')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Semester -->
                        <div>
                            <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                                Semester
                            </label>
                            <select id="semester" 
                                    name="semester" 
                                    class="w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                    required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil" {{ old('semester', $tahunAkademikTeks->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester', $tahunAkademikTeks->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Aktif" {{ old('status', $tahunAkademikTeks->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-Aktif" {{ old('status', $tahunAkademikTeks->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('tahunAkademik-teks.index') }}" 
                               class="w-full sm:w-auto bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-lg transition duration-300 text-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- Tidak ada skrip khusus yang dibutuhkan untuk halaman ini -->
@endpush