@extends('layouts.app')

@section('title', 'Survei')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('main')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Daftar Data Survei</h1>
            <nav class="flex mt-2 text-sm">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2 text-gray-500">/</span>
                <a href="{{ route('survei.index') }}" class="text-blue-600 hover:text-blue-800">Survei</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-500">Semua Isi Survei</span>
            </nav>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div id="success-message" class="fixed top-4 right-4 z-50 px-6 py-3 bg-green-100 border border-green-400 text-green-700 rounded-md shadow-md transition-all duration-500 transform translate-x-0">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
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

        <!-- Error Message -->
        @if(session('error'))
            <div id="error-message" class="fixed top-4 right-4 z-50 px-6 py-3 bg-red-100 border border-red-400 text-red-700 rounded-md shadow-md transition-all duration-500 transform translate-x-0">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
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

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Ada {{ $errors->count() }} kesalahan pada form Anda
                        </h3>
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

        <!-- Form -->
        <form method="POST" action="{{ route('instrumen.store') }}">
            @csrf

            <input type="hidden" name="select_all" id="selectAllInput" value="0">

            <!-- Tahun Akademik Card -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Data Tahun Akademik</h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tahun Akademik
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pilih
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($surveiTahun as $index => $tahun)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $tahun->tahunAkademik->tahun ?? 'Tidak ada' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($tahun->tahunAkademik->status == 'Aktif')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $tahun->tahunAkademik->status }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $tahun->tahunAkademik->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="checkbox" name="tahun_akademik[]" value="{{ $tahun->id }}" 
                                                {{ old('tahun_akademik') && in_array($tahun->id, old('tahun_akademik')) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data tahun akademik.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Role Selection -->
            <div class="bg-white shadow rounded-lg mb-6 p-6">
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Pengguna Untuk Pertanyaan Instrumen
                    </label>
                    <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" disabled selected>Pilih Pengguna</option>
                        @foreach ($roles as $role)
                            <option value="{{ strtolower(str_replace(' ', '_', $role)) }}">
                                {{ ucwords($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Pertanyaan Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Data Pertanyaan</h2>
                    <button type="button" id="selectAllBtn" class="px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                        Pilih Semua
                    </button>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Standar
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pertanyaan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keterangan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pilih
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($surveis as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $item->standar ?? 'Data tidak ditemukan' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $item->pertanyaan ?? 'Data tidak ditemukan' }}
                                        </td>

                                        @php
                                            // Mengambil semua nilai yang terkait dengan pertanyaan_id
                                            $nilaiForPertanyaan = $nilaiItems->get($item->pertanyaan_id, collect([]));
                                        @endphp

                                        @if($nilaiForPertanyaan->isNotEmpty())
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                @foreach($nilaiForPertanyaan as $nilai)
                                                    {{ $nilai->nilai }} <br>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                @foreach($nilaiForPertanyaan as $nilai)
                                                    {{ $nilai->keterangan }} <br>
                                                @endforeach
                                            </td>
                                        @else
                                            <td class="px-6 py-4 text-sm text-gray-500">-</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">-</td>
                                        @endif
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="checkbox" name="pertanyaan_ids[]" value="{{ $item->id }}" 
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            
                                            <!-- Menambahkan input tersembunyi untuk nilai_ids jika nilai ada -->
                                            @if($nilaiForPertanyaan->isNotEmpty())
                                                @foreach ($nilaiForPertanyaan as $nilai)
                                                    <input type="hidden" name="nilai_ids[]" value="{{ $nilai->id }}"> 
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada pertanyaan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6 flex justify-center">
                        {{ $surveis->links() }}
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            <i class="far fa-save mr-2"></i> Tambah Instrumen
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script untuk memilih semua checkbox pertanyaan
    document.getElementById('selectAllBtn').addEventListener('click', function () {

        const checkboxes = document.querySelectorAll('input[name="pertanyaan_ids[]"]');
        const hiddenInput = document.getElementById('selectAllInput');

        const allChecked = Array.from(checkboxes).every(cb => cb.checked);

        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
        });

        if (!allChecked) {
            hiddenInput.value = 1;
            this.textContent = "Batal Pilih Semua";
        } else {
            hiddenInput.value = 0;
            this.textContent = "Pilih Semua";
        }

    });
    
    // Custom styling for pagination links
    document.addEventListener('DOMContentLoaded', function() {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            if (!link.classList.contains('active')) {
                link.classList.add('px-3', 'py-1', 'ml-0', 'mr-1', 'text-sm', 'leading-tight', 
                    'text-gray-500', 'bg-white', 'border', 'border-gray-300', 
                    'hover:bg-gray-100', 'hover:text-gray-700', 'rounded');
            } else {
                link.classList.add('px-3', 'py-1', 'ml-0', 'mr-1', 'text-sm', 'leading-tight', 
                    'text-white', 'bg-blue-600', 'border', 'border-blue-600', 
                    'rounded');
            }
        });
    });
</script>
@endpush