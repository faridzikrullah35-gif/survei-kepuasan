{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('main')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Halaman -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-2 text-gray-600">Hai, {{ Auth::user()->name }}! Selamat datang di dashboard.</p>
        </div>

        <!-- Grid responsif: 1 kolom (HP), 2 kolom (Tablet), 4 kolom (Desktop) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Kartu 1: Total Pertanyaan Kuantitatif -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-orange-100 rounded-full p-3">
                        <i class="fas fa-question text-orange-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Survei Kuantitatif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalInstrumen }}</p>
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Total Pertanyaan Kualitatif -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-500 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-teal-100 rounded-full p-3">
                        <i class="fas fa-comments text-teal-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Survei Kualitatif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalInstrumenTeks }}</p>
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Total Kuantitatif Terjawab -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Survei Kuantitatif Terjawab</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalTerjawab }}</p>
                    </div>
                </div>
            </div>

            <!-- Kartu 4: Total Kualitatif Terjawab -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                        <i class="fas fa-clipboard-check text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Survei Kualitatif Terjawab</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalKualitatifTerjawab }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script src=".../chart.js"></script>
    <script>
        // Kode untuk inisialisasi grafik
    </script>
@endpush --}}