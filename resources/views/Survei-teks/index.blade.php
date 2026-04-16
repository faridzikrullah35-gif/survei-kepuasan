@extends('layouts.app')

@section('title', 'Survei Teks')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('main')
<div class="min-h-screen bg-gray-50 py-4 sm:py-6 lg:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Daftar Survei Teks</h1>
            <nav class="flex mt-2 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 transition-colors">Dashboard</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-700">Survei Teks</span>
            </nav>
        </div>

        <!-- Success Message -->
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

        <!-- Error Message -->
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

        <!-- Form untuk submit data ke instrumen-teks -->
        <form action="{{ route('instrumen-teks.store') }}" method="POST">
            @csrf
            
            <!-- Card Tahun Akademik -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Data Tahun Akademik Kualitatif</h2>
                </div>
                
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tahun Akademik
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pilih
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($surveiTahunTeks as $index => $tahun)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $tahun->tahunAkademikTeks->tahun ?? 'Tidak ada' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            @if($tahun->tahunAkademikTeks->status == 'Aktif')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="w-2 h-2 mr-1.5 bg-green-400 rounded-full"></span>
                                                    {{ $tahun->tahunAkademikTeks->status }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <span class="w-2 h-2 mr-1.5 bg-red-400 rounded-full"></span>
                                                    {{ $tahun->tahunAkademikTeks->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                            <input type="checkbox" name="tahun_akademik_teks[]" value="{{ $tahun->id }}" 
                                                {{ old('tahun_akademik_teks') && in_array($tahun->id, old('tahun_akademik_teks')) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 sm:px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Belum ada data tahun akademik kualitatif.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card Role Selection -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Pilih Pengguna Untuk Pertanyaan Instrumen (Teks)</h2>
                </div>
                
                <div class="p-4 sm:p-6">
                    <div class="w-full sm:w-1/2">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Pilih Pengguna</label>
                        <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            <option value="" disabled selected>Pilih Pengguna</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Card Pertanyaan Kualitatif -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Data Pertanyaan Kualitatif</h2>
                    <button type="button" id="selectAllBtn" class="px-3 sm:px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                        Pilih Semua Survei
                    </button>
                </div>
                
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Standar
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pertanyaan
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pilih
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($surveiTeks as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">
                                            {{ $item->standar ?? 'Data tidak ditemukan' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">
                                            {{ $item->pertanyaan ?? 'Data tidak ditemukan' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                            <input type="checkbox" name="pertanyaan_teks_ids[]" value="{{ $item->id }}" 
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 sm:px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Belum ada data survei teks.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-4 sm:px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <i class="far fa-save mr-2"></i>
                            Tambah Instrumen Kualitatif
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
    // Menunggu sampai halaman siap
    document.addEventListener('DOMContentLoaded', function() {
        // Mengambil tombol dan checkbox
        const selectAllBtn = document.getElementById('selectAllBtn');
        const checkboxes = document.querySelectorAll('input[name="pertanyaan_teks_ids[]"]');

        // Fungsi untuk memilih semua checkbox
        selectAllBtn.addEventListener('click', function() {
            // Cek status checkbox pertama untuk memilih/menghapus semua
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

            // Pilih atau hapus centang semua checkbox
            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });

            // Mengubah teks tombol berdasarkan status checkbox
            if (allChecked) {
                selectAllBtn.textContent = 'Pilih Semua Survei'; // Ubah kembali jika sudah semua dipilih
            } else {
                selectAllBtn.textContent = 'Hapus Pilihan Semua Survei'; // Ubah teks tombol jika checkbox belum semuanya dipilih
            }
        });
    });
    </script>
@endpush