@extends('layouts.app')

@section('title', 'Dashboard User')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <style>
        .modal-backdrop {
            display: none !important;
        }

        .equal-height-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .wide-card {
            width: 100%;
            max-width: none;
        }

        .wide-card .card-header {
            padding-bottom: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .wide-card .stat-card {
            padding: 1.5rem;
        }

        .wide-card .stat-value {
            font-size: 2.5rem;
        }

        .wide-card .survey-item {
            padding: 1rem;
        }

        .wide-card .survey-badge {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('main')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-2 text-lg text-gray-600">
            Hai, {{ Auth::user()->name }}!
            <span class="font-medium text-gray-800">({{ Auth::user()->role }})</span>
        </p>
        <p class="mt-1 text-gray-500">
            Selamat datang. Silahkan berikan penilaian survei Anda.
        </p>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-1 gap-6">
        <div class="equal-height-card wide-card bg-white rounded-lg shadow-md p-8 border-l-4 border-indigo-500">
            <div class="card-content">

                <!-- Statistik -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="equal-height-card bg-gray-50 rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-4">
                                <i class="fas fa-tasks text-green-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-base font-medium text-gray-600">Total Survei</p>
                                <p class="stat-value font-bold text-gray-900">
                                    {{ 
                                        $standarSurvei->sum('jumlah') 
                                        + ($standarSurveiTeks->sum('jumlah') ?? 0) 
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="equal-height-card bg-gray-50 rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-full p-4">
                                <i class="fas fa-layer-group text-blue-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-base font-medium text-gray-600">Kategori Survei</p>
                                <p class="stat-value font-bold text-gray-900">
                                    {{ 
                                        $standarSurvei->count() 
                                        + ($standarSurveiTeks->count() ?? 0) 
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Header List -->
                <div class="card-header flex items-center border-b border-gray-200">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-full p-4">
                        <i class="fas fa-list-check text-indigo-500 text-2xl"></i>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-900">
                        Survei Aktif
                    </h3>
                </div>

                <!-- List Survei (CLICKABLE) - RESPONSIVE -->
                <div class="flex-grow mt-6">
                    <div class="space-y-4">
                        @forelse ($standarSurvei as $standar => $data)
                            <a href="{{ route('survei.by-standar', $standar) }}"
                            class="survey-item block flex flex-col sm:flex-row sm:justify-between sm:items-center p-5 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">

                                <!-- Bagian Kiri: Ikon dan Judul -->
                                <div class="flex items-center space-x-4 mb-3 sm:mb-0">
                                    <div class="flex-shrink-0 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                        <i class="fas fa-poll text-white text-lg"></i>
                                    </div>
                                    <span class="text-base font-bold text-white">
                                        {{ $data['standar'] }}
                                    </span>
                                </div>

                                <!-- Bagian Kanan: Badge -->
                                <span class="survey-badge inline-flex items-center self-start sm:self-auto px-3.5 py-1.5 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm text-white">
                                    <i class="fas fa-star mr-1.5 text-xs"></i>
                                    {{ $data['jumlah'] }} Pertanyaan
                                </span>
                            </a>
                        @empty
                            <div class="text-center py-12">
                                <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
                                <p class="text-base text-gray-500">
                                    Belum ada data standar survei
                                </p>
                            </div>
                        @endforelse
        
                    {{-- ================= SURVEI KUALITATIF ================= --}}
                        <div class="mt-10">

                            <!-- Header -->
                            <div class="card-header flex items-center border-b border-gray-200 mb-6">
                                <div class="flex-shrink-0 bg-pink-100 rounded-full p-4">
                                    <i class="fas fa-comment-dots text-pink-500 text-2xl"></i>
                                </div>
                                <h3 class="ml-4 text-xl font-semibold text-gray-900">
                                    Survei Ulasan & Masukan
                                </h3>
                            </div>

                            <!-- List Survei Kualitatif -->
                            <div class="space-y-4">
                                @forelse ($standarSurveiTeks as $standar => $data)
                                    <a href="{{ route('instrumen-teks.by-standar', $standar) }}"
                                    class="survey-item block flex flex-col sm:flex-row sm:justify-between sm:items-center p-5
                                            bg-gradient-to-r from-pink-500 to-rose-600 rounded-lg shadow-lg
                                            hover:shadow-xl hover:scale-[1.02] transition-all duration-300">

                                        <!-- Kiri -->
                                        <div class="flex items-center space-x-4 mb-3 sm:mb-0">
                                            <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                                <i class="fas fa-align-left text-white text-lg"></i>
                                            </div>
                                            <span class="text-base font-bold text-white">
                                                {{ $data['standar'] }}
                                            </span>
                                        </div>

                                        <!-- Kanan -->
                                        <span class="survey-badge inline-flex items-center self-start sm:self-auto
                                                    px-3.5 py-1.5 rounded-full text-sm font-medium
                                                    bg-white/20 text-white">
                                            {{ $data['jumlah'] }} Pertanyaan
                                        </span>
                                    </a>
                                @empty
                                    <div class="text-center py-10">
                                        <i class="fas fa-comment-slash text-gray-300 text-5xl mb-4"></i>
                                        <p class="text-base text-gray-500">
                                            Belum ada survei kualitatif
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    {{-- ================= END SURVEI KUALITATIF ================= --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('scrollDownButton')?.addEventListener('click', function () {
        window.scrollBy({
            top: window.innerHeight,
            behavior: 'smooth'
        });
    });
</script>
@endpush
