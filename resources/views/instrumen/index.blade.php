@extends('layouts.app')

@section('title', 'Survei Kepuasan')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
        
    <style>
        .modal-backdrop {
            display:none !important;
        }
        
        .table-custom {
            border: 1px solid #e5e7eb;
            border-collapse: collapse;
        }

        .table-custom th,
        .table-custom td {
            border: 1px solid #e5e7eb;
            padding: 12px;
        }

        .table-custom th {
            background-color: #f9fafb;
        }

        .hidden-column {
            display: none !important;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
@endpush

@section('main')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Survei Kepuasan {{ ucfirst(auth()->user()->role) }}
                    </h1>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 fade-in" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button onclick="document.getElementById('success-message').style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 fade-in" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button onclick="document.getElementById('error-message').style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Main Content -->
            <div class="bg-white shadow-sm rounded-lg p-6">

                @auth
    @if(auth()->user()->role === 'admin')
        <!-- Filter Section -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">
                Pilih Filter Data Untuk Menampilkan Data Survei
            </h3>

            <form action="{{ route('instrumen.index') }}" method="GET"
                  class="flex flex-col sm:flex-row gap-3">

                <div class="flex-1">
                    <select name="tahun_akademik_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Pilih Tahun Akademik</option>
                        @foreach($tahunAkademik as $tahun)
                            @if($tahun->status === 'Aktif')
                                <option value="{{ $tahun->id }}"
                                    {{ request('tahun_akademik_id') == $tahun->id ? 'selected' : '' }}>
                                    {{ $tahun->tahun }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="flex-1">
                    <select name="standar_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Pilih Standar</option>
                        @foreach($standarList as $standar)
                            <option value="{{ $standar }}" {{ request('standar_filter') == $standar ? 'selected' : '' }}>
                                {{ $standar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>

                    <a href="{{ route('instrumen.index') }}"
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>

            </form>
        </div>
    @endif
@endauth

{{-- Bagian ini menggantikan seluruh blok @foreach modal --}}
{{-- Hanya tampilkan jika user bukan admin --}}
@if(auth()->user()->role !== 'admin')
<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 text-gray-800">
        <p><span class="font-bold">Standar Survei:</span> {{ $instrumens->first()?->survei->standar ?? '-' }}</p>
        <p><span class="font-bold">Tahun Akademik:</span> {{ $instrumens->first()?->tahunAkademik->tahun ?? '-' }}</p>
    </h2>

    {{-- Biodata --}}
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden mb-8">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Biodata Responden</h3>
            @php $isFilled = !empty($biodata); @endphp
            <form id="form-biodata" action="{{ route('biodata.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if(in_array(auth()->user()->role, ['mahasiswa', 'alumni']))
                        {{-- Fakultas --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                            <textarea name="fakultas" rows="2" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 {{ $isFilled ? 'bg-gray-100' : '' }}"
                                placeholder="Isi fakultas Anda..." {{ $isFilled ? 'readonly' : 'required' }}>{{ $biodata->fakultas ?? '' }}</textarea>
                        </div>

                        {{-- Program Studi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                            <textarea name="prodi" rows="2" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 {{ $isFilled ? 'bg-gray-100' : '' }}"
                                placeholder="Isi program studi Anda..." {{ $isFilled ? 'readonly' : 'required' }}>{{ $biodata->prodi ?? '' }}</textarea>
                        </div>

                        {{-- Semester --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                            <textarea name="semester" rows="2" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 {{ $isFilled ? 'bg-gray-100' : '' }}"
                                placeholder="Isi semester Anda..." {{ $isFilled ? 'readonly' : 'required' }}>{{ $biodata->semester ?? '' }}</textarea>
                        </div>

                    @elseif(auth()->user()->role === 'dosen')
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                            <textarea name="fakultas" rows="2" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 {{ $isFilled ? 'bg-gray-100' : '' }}"
                                placeholder="Isi fakultas Anda..." {{ $isFilled ? 'readonly' : 'required' }}>{{ $biodata->fakultas ?? '' }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Homebase / Prodi</label>
                            <textarea name="homebase" rows="2" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 {{ $isFilled ? 'bg-gray-100' : '' }}"
                                placeholder="Isi homebase/prodi Anda..." {{ $isFilled ? 'readonly' : 'required' }}>{{ $biodata->homebase ?? '' }}</textarea>
                        </div>

                    @elseif(auth()->user()->role === 'tenaga_kependidikan')
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas / Unit</label>
                            <textarea name="fakultas_unit" rows="2"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 {{ $isFilled ? 'bg-gray-100' : '' }}"
                                placeholder="Isi fakultas/unit Anda..." {{ $isFilled ? 'readonly' : 'required' }}>{{ $biodata->fakultas_unit ?? '' }}</textarea>
                        </div>

                    @elseif(in_array(auth()->user()->role, ['dinas', 'masyarakat']))
                        {{-- Unit --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                            <textarea name="unit" rows="2"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 {{ $isFilled ? 'bg-gray-100' : '' }}"
                                placeholder="Isi unit..." {{ $isFilled ? 'readonly' : 'required' }}>{{ $biodata->unit ?? '' }}</textarea>
                        </div>

                        {{-- Sub Unit --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sub Unit</label>
                            <textarea name="sub_unit" rows="2"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 {{ $isFilled ? 'bg-gray-100' : '' }}"
                                placeholder="Isi sub unit..." {{ $isFilled ? 'readonly' : 'required' }}>{{ $biodata->sub_unit ?? '' }}</textarea>
                        </div>
                    @endif
                </div>
                <div class="mt-6 flex justify-center">
                    <button type="submit" {{ $isFilled ? 'disabled' : '' }}
                        class="px-6 py-2.5 rounded-md font-medium text-white {{ $isFilled ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }}">
                        <i class="{{ $isFilled ? 'fas fa-check' : 'fas fa-save' }} mr-2"></i> {{ $isFilled ? 'Tersimpan' : 'Simpan Biodata' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- FORM SURVEI --}}
<div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden mb-8">
    <div class="p-4 sm:p-6 lg:p-8">
        {{-- Cek apakah user sudah menjawab --}}
        @php
            $userId = auth()->id();
            $userJawaban = $instrumens->mapWithKeys(function($instrumen) use ($userId) {
                $record = $instrumen->nilaiInstrumenMahasiswa->where('user_id', $userId)->first();
                return [$instrumen->id => $record];
            });
            $sudahMenjawab = $userJawaban->filter()->isNotEmpty();
            $kritikSaran = $userJawaban->filter()->last()?->kritik_saran ?? '';
        @endphp

        {{-- Notifikasi --}}
        @if($sudahMenjawab)
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md text-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                Anda sudah mengisi survei ini.
            </div>
        @endif

        <form id="form-survei" action="{{ route('nilai-instrumen-mahasiswa.store') }}" method="POST">
            @csrf
            
            <!-- Header Survei -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Form Survei</h1>
                <div class="h-1 w-20 bg-blue-500 mx-auto rounded"></div>
            </div>
            
            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="w-full border-collapse bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                            <th class="border px-4 py-4 text-left font-semibold">Pertanyaan Survei</th>
                            @foreach(['Sangat Baik','Baik','Kurang','Sangat Kurang'] as $label)
                                <th class="border px-2 sm:px-4 py-4 text-center font-semibold">{{ $label }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instrumens as $index => $instrumen)
                            @php
                                $jawaban = $userJawaban[$instrumen->id] ?? null;
                                $nilaiUser = $jawaban?->nilai;
                                $isDisabled = $sudahMenjawab ? 'disabled' : '';
                                $rowColor = $index % 2 == 0 ? 'bg-gray-50' : 'bg-white';
                            @endphp
                            <tr class="{{ $rowColor }} {{ $sudahMenjawab ? 'opacity-70' : '' }} hover:bg-blue-50 transition-colors">
                                <td class="border px-4 py-4 font-medium text-gray-700">{{ $instrumen->pertanyaan->pertanyaan }}</td>
                                @foreach([4,3,2,1] as $nilai)
                                    <td class="border px-2 sm:px-4 py-4 text-center">
                                        <div class="flex justify-center">
                                            <input type="radio"
                                                name="nilai[{{ $instrumen->id }}]"
                                                value="{{ $nilai }}"
                                                id="nilai-{{ $instrumen->id }}-{{ $nilai }}"
                                                class="w-5 h-5 text-blue-600 focus:ring-blue-500 {{ $sudahMenjawab ? 'cursor-not-allowed' : '' }}"
                                                {{ $nilaiUser == $nilai ? 'checked' : '' }}
                                                {{ $isDisabled }}
                                                required>
                                            <label for="nilai-{{ $instrumen->id }}-{{ $nilai }}" class="sr-only">{{ $nilai }}</label>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- FORM KRITIK & SARAN --}}
            <div class="mt-8 sm:mt-12">
                <div class="mb-6 text-center">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Kritik & Saran</h2>
                    <div class="h-1 w-20 bg-blue-500 mx-auto rounded"></div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Standar Survei:</p>
                            <p class="font-semibold text-gray-800">{{ $instrumens->first()?->survei->standar ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Tahun Akademik:</p>
                            <p class="font-semibold text-gray-800">{{ $instrumens->first()?->tahunAkademik->tahun ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8 border border-gray-200">
                    <label for="kritik_saran" class="block text-gray-700 font-medium mb-2">Tulis kritik atau saran Anda:</label>
                    <textarea
                        id="kritik_saran"
                        name="kritik_saran"
                        rows="5"
                        class="w-full border border-gray-300 rounded-lg p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all {{ $sudahMenjawab ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                        placeholder="Tulis kritik atau saran..."
                        {{ $sudahMenjawab ? 'disabled' : 'required' }}
                    >{{ old('kritik_saran', $kritikSaran) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <button type="submit" id="btnSubmit"
                        class="px-6 sm:px-8 py-3 rounded-lg font-medium transition-all transform hover:scale-105 {{ $sudahMenjawab ? 'bg-gray-400 text-white cursor-not-allowed' : 'bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl' }}"
                        {{ $sudahMenjawab ? 'disabled' : '' }}>
                    <i class="fas fa-save mr-2"></i> Simpan Survei
                </button>
            </div>
        </form>
    </div>
</div>

</div>
@endif

                <!-- Data Table -->
                @if (auth()->user()->role === 'admin') 
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Standar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Survei Untuk Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    <th class="hidden-column px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" id="jumlahPenggunaHeader">Jumlah Pengguna & Survei Terjawab</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($instrumens as $index => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $instrumens->firstItem() + $index }}</td>
                                        <td class="px-6 py-4">{{ $item->survei->standar ?? 'Tidak ada' }}</td>
                                        <td class="px-6 py-4">{{ $item->survei->pertanyaan ?? 'Tidak ada' }}</td>
                                        <td class="px-6 py-4">
                                            {{ $item->role ? ucwords(str_replace('_',' ',$item->role)) : 'Tidak ada' }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!-- Tombol hapus satu -->
                                            <form action="{{ route('instrumen.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors" onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                        <td class="hidden-column px-6 py-4" id="jumlahPenggunaCell-{{ $item->id }}">
                                            @php
                                                $role = $item->role;
                                                $totalPengguna = \App\Models\User::count();
                                                $jumlahTerjawab = $item->nilaiInstrumenMahasiswa()
                                                    ->where('status', 'terjawab')
                                                    ->count();
                                            @endphp

                                            {{ $role }} - Terjawab {{ $jumlahTerjawab }} dari {{ $totalPengguna }} pengguna
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-red-500">Tidak ada data yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:justify-between">

                            <div class="text-sm text-gray-600">
                                Menampilkan {{ $instrumens->firstItem() }} - {{ $instrumens->lastItem() }} 
                                dari {{ $instrumens->total() }} data
                            </div>

                            <div class="overflow-x-auto">
                                {{ $instrumens->links() }}
                            </div>

                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                        <div>
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('instrumen.nonaktif') }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
                                    <i class="fas fa-list mr-2"></i> Lihat Instrumen Non-aktif
                                </a>
                            @endif
                        </div>

                        <div>
                            <button id="toggleAllColumnButton" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-eye mr-2"></i> Tampilkan Info Pengguna
                            </button>
                        </div>

                        <div>
                            @if (count($instrumens) > 0)
                                <form action="{{ route('instrumen.destroyAll') }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors" onclick="return confirm('Yakin ingin menghapus semua data?')">
                                        <i class="fas fa-trash-alt mr-2"></i> Hapus Semua Survei
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @else
                    @if(request()->has('tahun_akademik_id') || request()->has('pertanyaan_id'))
                        @if($instrumens->isEmpty())
                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">Tidak ada data yang ditemukan untuk filter yang dipilih.</span>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Standar</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>

                                            @if (Auth::user()->role === 'admin')
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Untuk Role</th>
                                            @endif
                                            
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Terjawab</th>

                                            @if(in_array(auth()->user()->role, ['user', 'mahasiswa', 'dosen', 'tenaga_kependidikan']))
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($instrumens as $index => $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $index + 1 }}</td>
                                                <td class="px-6 py-4">{{ $item->survei->standar ?? 'Tidak ada' }}</td>
                                                <td class="px-6 py-4">{{ $item->survei->pertanyaan ?? 'Tidak ada' }}</td>

                                                @if (Auth::user()->role === 'admin')
                                                    <td class="px-6 py-4">{{ ucfirst($item->role ?? 'Tidak ada') }}</td>
                                                @endif

                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $nilaiInstrumenMahasiswa = $item->nilaiInstrumenMahasiswa->first();
                                                    @endphp

                                                    @if($nilaiInstrumenMahasiswa && $nilaiInstrumenMahasiswa->status === 'terjawab')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Terjawab
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Belum Terjawab
                                                        </span>
                                                    @endif
                                                </td>
                                                
                                                @if(in_array(auth()->user()->role, ['mahasiswa', 'dosen', 'tenaga_kependidikan']))
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <button type="button" class="text-blue-600 hover:text-blue-900" data-bs-toggle="modal" 
                                                                data-bs-target="#instrumenKeteranganModalLabel-{{ $item->id }}" 
                                                                data-id="{{ $item->id }}" 
                                                                data-nilai="{{ $item->nilai }}" 
                                                                data-keterangan="{{ $item->keterangan }}">
                                                            <i class="fas fa-edit"></i> Jawab
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-6 py-4 text-center text-red-500">Tidak ada data yang ditemukan untuk role Anda</td>
                                            </tr>
                                        @endforelse
                                        <script>
                                            var instrumenIds = @json($instrumens->pluck('id')->toArray());

                                            function getNextItemId(currentId) {
                                                let currentIndex = instrumenIds.indexOf(parseInt(currentId));
                                                if (currentIndex >= 0 && currentIndex < instrumenIds.length - 1) {
                                                    return instrumenIds[currentIndex + 1];
                                                }
                                                return null;
                                            }
                                        </script>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: "3000"
};

 $(document).ready(function() {

    // --- Handler untuk Form Biodata ---
    $("#form-biodata").on("submit", function(e) {
        e.preventDefault();

        // Validasi sederhana sebelum AJAX
        let isValid = true;
        $(this).find('.biodata-input[required]').each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).addClass('border-red-500'); // Beri indikasi visual
            } else {
                $(this).removeClass('border-red-500');
            }
        });

        if (!isValid) {
            toastr.error('Harap isi semua field biodata yang wajib diisi!');
            return; // Hentikan eksekusi jika tidak valid
        }

        let form = $(this);
        let button = $("#btnSimpan");

        // Cegah submit ganda
        if (button.prop('disabled')) return;

        button.prop("disabled", true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: form.serialize(),
            success: function(response) {
                toastr.success("Biodata berhasil disimpan.");
                // Nonaktifkan input dan ubah tombol
                form.find(".biodata-input").prop("readonly", true).addClass("bg-gray-100");
                button.prop("disabled", true)
                    .removeClass("bg-green-600 hover:bg-green-700")
                    .addClass("bg-gray-400")
                    .html('<i class="fas fa-check mr-2"></i>Tersimpan');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                button.prop("disabled", false).html('<i class="fas fa-save mr-2"></i>Simpan Biodata');
                toastr.error(xhr.responseJSON?.message || "Gagal menyimpan biodata.");
            }
        });
    });


    // --- Handler untuk Form Survei ---
    $("#form-survei").on("submit", function(e) {
        e.preventDefault();

        let form = $(this);
        let button = $("#btnSubmit");

        // Cegah submit ganda
        if (button.prop('disabled')) return;

        // Validasi HTML5 sebelum AJAX
        // Cari input pertama yang tidak valid
        let firstInvalid = form.find(':invalid').first();
        if (firstInvalid.length) {
            firstInvalid[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalid.focus();
            toastr.error('Harap isi semua pertanyaan dan kritik & saran sebelum menyimpan!');
            return; // Hentikan eksekusi jika tidak valid
        }

        button.prop("disabled", true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: form.serialize(),
            success: function(response) {
                toastr.success("Survei berhasil disimpan.");
                // Nonaktifkan semua input dan ubah tombol
                form.find("input[type='radio'], textarea")
                    .prop("disabled", true)
                    .addClass("cursor-not-allowed bg-gray-100");
                button.prop("disabled", true)
                    .removeClass("bg-blue-600 hover:bg-blue-700")
                    .addClass("bg-gray-400")
                    .html('<i class="fas fa-check mr-2"></i>Survei Tersimpan');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                button.prop("disabled", false).html('<i class="fas fa-save mr-2"></i>Simpan Survei');
                toastr.error(xhr.responseJSON?.message || "Terjadi kesalahan saat menyimpan.");
            }
        });
    });

});
</script>

@endpush