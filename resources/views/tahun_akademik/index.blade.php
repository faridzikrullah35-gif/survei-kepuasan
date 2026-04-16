@extends('layouts.app')

@section('title', 'Daftar Tahun Akademik')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('main')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Tahun Akademik</h1>
            <nav class="flex mt-2 text-sm">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2 text-gray-500">/</span>
                <a href="{{ route('tahun_akademik.index') }}" class="text-blue-600 hover:text-blue-800">Tahun Akademik</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-500">Semua Isi Tahun Akademik</span>
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

        <!-- Main Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Daftar Tahun Akademik</h2>
                <a href="{{ route('tahun_akademik.create') }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-plus mr-2"></i> Isi Tahun Akademik
                </a>
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
                                    Semester
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tahunAkademik as $index => $tahun)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $loop->iteration + ($tahunAkademik->currentPage() - 1) * $tahunAkademik->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $tahun->tahun }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $tahun->semester }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($tahun->status == 'Aktif')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $tahun->status }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ $tahun->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('tahun_akademik.edit', $tahun->id) }}" class="px-3 py-1.5 bg-amber-500 text-white rounded hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('tahun_akademik.destroy', $tahun->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus Tahun Akademik ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data Tahun Akademik.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $tahunAkademik->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Custom styling for pagination links if needed
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