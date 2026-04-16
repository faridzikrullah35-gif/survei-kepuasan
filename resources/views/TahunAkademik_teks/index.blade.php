@extends('layouts.app')

@section('title', 'Daftar Tahun Akademik')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom styles for pagination */
        .pagination-container .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .pagination-container .pagination li {
            margin: 0 2px;
        }
        
        .pagination-container .pagination a,
        .pagination-container .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .pagination-container .pagination a:not(.active):hover {
            background-color: #f3f4f6;
        }
        
        .pagination-container .pagination .active {
            background-color: #2563eb;
            color: white;
        }
    </style>
@endpush

@section('main')
<div class="min-h-screen bg-gray-50 py-4 sm:py-6 lg:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Tahun Akademik</h1>
            <nav class="flex mt-2 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 transition-colors">Dashboard</a>
                <span class="mx-2 text-gray-500">/</span>
                <a href="{{ route('tahun_akademik.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors">Tahun Akademik</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-500">Semua Isi Tahun Akademik</span>
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

        <!-- Main Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Daftar Tahun Akademik</h2>
                <a href="{{ route('tahun_akademik_teks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-plus mr-2"></i> 
                    <span>Isi Tahun Akademik</span>
                </a>
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
                                    Semester
                                </th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse($tahunAkademikTeks as $index => $tahun)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 text-sm text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ $tahun->tahun }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ $tahun->semester }}
                                </td>
                                <td class="px-4 py-4">
                                    @if($tahun->status === 'Aktif')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center text-sm font-medium">
    <div class="flex justify-center gap-2">
        {{-- Edit --}}
        <a href="{{ route('tahunAkademik-teks.edit', $tahun->id) }}"
           class="inline-flex items-center px-3 py-1.5 bg-amber-500 text-white rounded-md hover:bg-amber-600 transition"
           title="Edit">
            <i class="fas fa-edit"></i>
        </a>

        {{-- Delete --}}
        <form action="{{ route('tahunAkademik-teks.destroy', $tahun->id) }}"
              method="POST"
              onsubmit="return confirm('Yakin mau hapus?')">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-600 transition"
                title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    Tidak ada data Tahun Akademik.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if (method_exists($tahunAkademikTeks, 'links'))
                    <div class="mt-6 flex justify-center pagination-container">
                        {{ $tahunAkademikTeks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Custom styling for pagination links
        const paginationContainer = document.querySelector('.pagination-container');
        if (paginationContainer) {
            const paginationLinks = paginationContainer.querySelectorAll('.pagination a, .pagination span');
            paginationLinks.forEach(link => {
                link.classList.add('text-sm');
                
                if (link.classList.contains('active')) {
                    link.classList.add('bg-blue-600', 'text-white');
                } else {
                    link.classList.add('text-gray-700', 'bg-white', 'border', 'border-gray-300', 'hover:bg-gray-50');
                }
            });
        }
    });
</script>
@endpush