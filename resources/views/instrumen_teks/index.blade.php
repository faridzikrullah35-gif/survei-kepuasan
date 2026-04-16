@extends('layouts.app')

@section('title', 'Survei Kepuasan')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('main')
<div class="min-h-screen bg-gray-50 py-4 sm:py-6 lg:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Survei Kepuasan</h1>
            <nav class="flex mt-2 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 transition-colors">Kembali ke Dashboard</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-700">Semua Data Instrumen Kualitatif</span>
            </nav>
        </div>

        <!-- Success & Error Messages -->
        @if(session('success'))
            <div id="success-message" class="fixed top-4 right-4 z-50 px-4 py-3 sm:px-6 bg-green-100 border border-green-400 text-green-700 rounded-md shadow-lg transition-all duration-500 transform translate-x-0">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm sm:text-base">{{ session('success') }}</span>
                </div>
            </div>
            <script>
                setTimeout(function() {
                    const element = document.getElementById('success-message');
                    element.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => element.remove(), 500);
                }, 3000);
            </script>
        @endif

        @if(session('error'))
            <div id="error-message" class="fixed top-4 right-4 z-50 px-4 py-3 sm:px-6 bg-red-100 border border-red-400 text-red-700 rounded-md shadow-lg transition-all duration-500 transform translate-x-0">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm sm:text-base">{{ session('error') }}</span>
                </div>
            </div>
            <script>
                setTimeout(function() {
                    const element = document.getElementById('error-message');
                    element.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => element.remove(), 500);
                }, 3000);
            </script>
        @endif

        @if(auth()->user()->role === 'admin')
            <!-- Filter Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">
                        Pilih Filter Data Untuk Menampilkan Data Survei
                    </h2>
                </div>

                <div class="p-4 sm:p-6">
                    <form action="{{ route('instrumen_teks.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label for="tahun_akademik_teks_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tahun Akademik
                                </label>
                                <select name="tahun_akademik_teks_id" id="tahun_akademik_teks_id"
                                    class="w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Pilih Tahun Akademik</option>
                                    @foreach($tahunAkademikTeks as $tahun)
                                        @if($tahun->status === 'Aktif')
                                            <option value="{{ $tahun->id }}"
                                                {{ request('tahun_akademik_teks_id') == $tahun->id ? 'selected' : '' }}>
                                                {{ $tahun->tahun }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="pertanyaan_teks_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pertanyaan Kualitatif
                                </label>
                                <select name="pertanyaan_teks_id" id="pertanyaan_teks_id"
                                    class="w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Pilih Pertanyaan Kualitatif</option>
                                    @foreach($pertanyaanTeks as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('pertanyaan_teks_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->standar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>

                            <a href="{{ route('instrumen_teks.index') }}"
                                class="px-4 py-2 bg-gray-500 text-white font-medium rounded-md hover:bg-gray-600 transition-colors">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endif


        <!-- Data Table Card -->
        @if(auth()->user()->role === 'admin' || (request()->has('pertanyaan_teks_id') && request('pertanyaan_teks_id') !== ''))
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Data Survei Kepuasan</h2>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Standar</th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Untuk Pengguna</th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Terjawab</th>
                                    @if(in_array(auth()->user()->role, ['mahasiswa', 'dosen', 'tenaga_kependidikan']))
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($instrumenTeks as $index => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">{{ $item->pertanyaanTeks->standar ?? 'Tidak ada' }}</td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">{{ $item->pertanyaanTeks->pertanyaan ?? 'Tidak ada' }}</td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($item->role ?? 'Tidak ada') }}</td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            @php
                                                $nilaiInstrumenTeks = $item->nilaiInstrumenTeks->first();
                                            @endphp
                                            @if($nilaiInstrumenTeks && $nilaiInstrumenTeks->status === 'terjawab')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="w-2 h-2 mr-1.5 bg-green-400 rounded-full"></span>
                                                    Terjawab
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <span class="w-2 h-2 mr-1.5 bg-red-400 rounded-full"></span>
                                                    Belum Terjawab
                                                </span>
                                            @endif
                                        </td>
                                        @if(in_array(auth()->user()->role, ['mahasiswa', 'dosen', 'tenaga_kependidikan']))
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <button type="button" class="text-blue-600 hover:text-blue-900 p-2 rounded-md hover:bg-blue-50 transition-colors" data-bs-toggle="modal" data-bs-target="#modal-nilai-{{ $item->id }}" title="Jawab">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ in_array(auth()->user()->role, ['mahasiswa', 'dosen', 'tenaga_kependidikan']) ? '6' : '5' }}" class="px-4 sm:px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Tidak ada data yang ditemukan untuk filter yang dipilih.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
        @endif

        <!-- Additional Actions for Admin -->
        @if(auth()->user()->role === 'admin')
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Aksi Tambahan</h2>
                </div>
                <div class="p-4 sm:p-6">
                    @forelse ($items as $item)
                        <a href="{{ route('index.nonaktif', ['id' => $item->id]) }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white font-medium rounded-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-list mr-2"></i> Lihat Instrumen Non-aktif
                        </a>
                    @empty
                        <p class="text-gray-500">Tidak ada instrumen tersedia.</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>

    {{-- Halaman Form Survei Kualitatif --}}
@if(in_array(auth()->user()->role, ['mahasiswa', 'dosen', 'tenaga_kependidikan']))
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 text-gray-800">
        Formulir Survei Kualitatif
    </h2>

    <div class="space-y-8">
        @foreach($instrumenTeks as $item)

        @php
            $currentJawaban = $item->nilaiInstrumenTeks
                ->where('user_id', auth()->id());

            $sudahMenjawab = $currentJawaban->isNotEmpty();
        @endphp

        <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 text-white">
                <h3 class="text-xl font-semibold mb-2">Survei Kualitatif</h3>
                <div class="text-sm space-y-1">
                    <p><span class="font-medium">Standar:</span> {{ $item->pertanyaanTeks->standar ?? 'Tidak ada' }}</p>
                    <p><span class="font-medium">Pertanyaan:</span> {{ $item->pertanyaanTeks->pertanyaan ?? 'Tidak ada' }}</p>
                </div>
            </div>

            <div class="p-6">

                {{-- FORM --}}
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">
                        Tulis Jawaban Anda
                    </h4>

                    @if($sudahMenjawab)
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
                            ✅ Anda sudah mengisi survei ini.
                        </div>
                    @endif

                    <form id="form-jawaban-{{ $item->id }}"
                          action="{{ route('nilai_instrumen_teks.store') }}"
                          method="POST"
                          class="space-y-4">
                        @csrf

                        <input type="hidden" name="instrumen_teks_id" value="{{ $item->id }}">

                        <div>
                            <textarea
                                name="jawaban"
                                id="jawaban-{{ $item->id }}"
                                rows="5"
                                placeholder="Tulis jawaban Anda di sini..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                {{ $sudahMenjawab ? 'disabled' : 'required' }}
                            ></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2.5 rounded-md font-medium transition-all
                                {{ $sudahMenjawab
                                    ? 'bg-gray-400 text-white cursor-not-allowed'
                                    : 'bg-purple-600 text-white hover:bg-purple-700 hover:scale-105' }}"
                                {{ $sudahMenjawab ? 'disabled' : '' }}>
                                <i class="fas fa-save mr-2"></i>
                                {{ $sudahMenjawab ? 'Sudah Dijawab' : 'Simpan Jawaban' }}
                            </button>
                        </div>
                    </form>
                </div>

                {{-- RIWAYAT --}}
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold text-gray-700 mb-3">
                        Riwayat Jawaban Anda
                    </h4>

                    <div class="overflow-x-auto border border-gray-300 rounded-lg">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Jawaban
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Tanggal
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="jawabanInstrumenTbody{{ $item->id }}"
                                   class="bg-white divide-y divide-gray-200">

                                @forelse($currentJawaban as $nilai)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $nilai->jawaban }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $nilai->created_at->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="noDataRow-{{ $item->id }}">
                                        <td colspan="2"
                                            class="px-4 py-6 text-center text-sm text-gray-500">
                                            Belum ada jawaban yang tersimpan.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        @endforeach
    </div>
</div>
@endif
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('submit', 'form[id^="form-jawaban-"]', function(e) {
    e.preventDefault();

    let form = $(this);
    let itemId = form.attr('id').replace('form-jawaban-', '');
    let formData = form.serialize();
    let textarea = $('#jawaban-' + itemId);
    let tbody = $('#jawabanInstrumenTbody' + itemId);

    if (textarea.val().trim() === '') {
        alert('Jawaban tidak boleh kosong!');
        return;
    }

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        success: function(response) {

            // hapus row kosong
            $('#noDataRow-' + itemId).remove();

            // append jawaban baru
            let newRow = `
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900">
                        ${response.jawaban}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500">
                        ${response.tanggal}
                    </td>
                </tr>
            `;

            tbody.append(newRow);

            // disable form setelah submit
            textarea.prop('disabled', true);
            form.find('button').prop('disabled', true)
                .removeClass('bg-purple-600 hover:bg-purple-700')
                .addClass('bg-gray-400')
                .html('<i class="fas fa-check mr-2"></i>Sudah Dijawab');

            alert('Jawaban berhasil disimpan!');
        },
        error: function(xhr) {
            if (xhr.status === 400) {
                alert(xhr.responseJSON.message);
            } else {
                alert('Terjadi kesalahan saat menyimpan data!');
            }
        }
    });
});
</script>
@endpush