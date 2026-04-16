@extends('layouts.app')

@section('title', 'Edit Tahun Akademik')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@section('main')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Tahun Akademik</h1>
            <nav class="flex mt-2 text-sm">
                <a href="{{ route('tahun_akademik.index') }}" class="text-blue-600 hover:text-blue-800">Tahun Akademik</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-500">Edit Tahun Akademik</span>
            </nav>
        </div>

        <!-- Main Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Edit Tahun Akademik</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('tahun_akademik.update', $tahunAkademik->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Tahun Akademik Input -->
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun Akademik
                        </label>
                        <input 
                            type="text" 
                            id="tahun" 
                            name="tahun" 
                            value="{{ old('tahun', $tahunAkademik->tahun) }}" 
                            placeholder="Contoh: 2023/2024"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required
                        >
                        @error('tahun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Semester Select -->
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                            Semester
                        </label>
                        <select 
                            id="semester" 
                            name="semester" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required
                        >
                            <option value="">-- Pilih Semester --</option>
                            <option value="Ganjil" {{ old('semester', $tahunAkademik->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ old('semester', $tahunAkademik->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Select -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select 
                            id="status" 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required
                        >
                            <option value="">-- Pilih Status --</option>
                            <option value="Aktif" {{ old('status', $tahunAkademik->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Non-Aktif" {{ old('status', $tahunAkademik->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                        >
                            Simpan
                        </button>
                        
                        <a 
                            href="{{ route('tahun_akademik.index') }}" 
                            class="px-6 py-2 bg-gray-500 text-white font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-center"
                        >
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection