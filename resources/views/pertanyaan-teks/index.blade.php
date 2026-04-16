@extends('layouts.app')

@section('title', 'Survei Kualitatif')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Menyembunyikan backdrop modal yang mungkin bentrok dengan z-index */
        .modal-backdrop {
            display: none !important;
        }
        .modal {
            z-index: 1060;
        }
        .modal-backdrop {
            z-index: 1040;
        }
    </style>
@endpush

@section('main')
<div class="main-content bg-gray-50 p-4 md:p-6 lg:p-8">
    <section class="section">
        <!-- Header Section -->
        <div class="bg-white shadow-sm p-4 md:p-6 mb-6 rounded-lg">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">Survei Kualitatif</h1>
            <div class="flex text-sm mt-2 text-gray-600" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('pertanyaan-teks.index') }}" class="text-blue-600 hover:underline">Survei Kualitatif</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700">Survei Kualitatif</span>
            </div>
        </div>

        <!-- Body Section -->
        <div class="section-body">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-6">Survei Kualitatif</h2>

            <!-- Pesan Sukses dan Error -->
            @if(session('success'))
                <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 mx-auto text-center text-sm md:text-base">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        const element = document.getElementById('success-message');
                        if(element) element.style.display = 'none';
                    }, 3000);
                </script>
            @endif

            @if(session('error'))
                <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 mx-auto text-center text-sm md:text-base">
                    {{ session('error') }}
                </div>
                <script>
                    setTimeout(function() {
                        const element = document.getElementById('error-message');
                        if(element) element.style.display = 'none';
                    }, 3000);
                </script>
            @endif

            <!-- Card/Table Container -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 md:p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <h4 class="text-base md:text-lg font-medium text-gray-800">Daftar Survei Kualitatif</h4>
                    <a href="{{ route('pertanyaan-teks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 text-center self-start sm:self-auto">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Survei
                    </a>
                </div>
                
                <div class="p-4 md:p-6">
                    <!-- Wrapper untuk membuat tabel bisa di-scroll horizontal di mobile -->
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-max">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-200">
                                    <th class="px-3 py-3 text-center text-xs md:text-sm font-medium text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-3 py-3 text-left text-xs md:text-sm font-medium text-gray-700 uppercase tracking-wider">Standar Kualitatif</th>
                                    <th class="px-3 py-3 text-left text-xs md:text-sm font-medium text-gray-700 uppercase tracking-wider">Pertanyaan</th>
                                    <th class="px-3 py-3 text-center text-xs md:text-sm font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pertanyaans as $index => $pertanyaan)
                                    <tr id="row-{{ $pertanyaan->id }}" class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ ($pertanyaans->currentPage() - 1) * $pertanyaans->perPage() + $loop->iteration }}</td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-700">{{ $pertanyaan->standar }}</td>
                                        <td class="px-3 py-4 text-sm text-gray-700">{{ $pertanyaan->pertanyaan }}</td>
                                        <td class="px-3 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('pertanyaan-teks.edit', $pertanyaan->id) }}" class="text-yellow-600 hover:text-yellow-800 p-1.5 rounded-md hover:bg-yellow-50 transition duration-150" title="Edit">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('pertanyaan-teks.destroy', $pertanyaan->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 p-1.5 rounded-md hover:bg-red-50 transition duration-150" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-8 text-center text-sm text-gray-500 bg-gray-50">Tidak ada data survei.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6 flex justify-center">
                        {{ $pertanyaans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script>
        // Menangani modal trigger untuk pertanyaan tertentu (jika modal digunakan)
        const modal = document.getElementById('staticBackdrop');
        if (modal) {
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const pertanyaanId = button.getAttribute('data-id');
                const standar = button.getAttribute('data-standar');
                const pertanyaan = button.getAttribute('data-pertanyaan');

                const modalStandar = document.getElementById('modal-standar');
                const modalPertanyaan = document.getElementById('modal-pertanyaan');
                const pertanyaanIdInput = document.getElementById('pertanyaan-teks-id');

                if(modalStandar) modalStandar.textContent = standar;
                if(modalPertanyaan) modalPertanyaan.textContent = pertanyaan;
                if(pertanyaanIdInput) pertanyaanIdInput.value = pertanyaanId;
            });
        }
    </script>
@endpush