@extends('layouts.app')

@section('title', 'Instrumen Non-Aktif')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('main')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-900 text-center">Instrumen Non-Aktif</h1>
            </div>

            <!-- Main Content -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Tabel Instrumen Non-Aktif</h2>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Akademik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Standar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($shows as $index => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->tahunAkademik->tahun ?? 'Tidak ada' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->pertanyaan->standar ?? 'Tidak ada' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->pertanyaan->pertanyaan ?? 'Tidak ada' }}</td>
                                        
                                        @php
                                            $nilaiForPertanyaan = App\Models\Nilai::where('pertanyaan_id', $item->pertanyaan_id)->get();
                                        @endphp
                                        
                                        @if($nilaiForPertanyaan->isNotEmpty())
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                @foreach($nilaiForPertanyaan as $nilai)
                                                    {{ $nilai->nilai }}<br>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                @foreach($nilaiForPertanyaan as $nilai)
                                                    {{ $nilai->keterangan }}<br>
                                                @endforeach
                                            </td>
                                        @else
                                            <td class="px-6 py-4 text-sm text-gray-500">-</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">-</td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <form action="{{ route('instrumen-non-aktif.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada instrumen non-aktif.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-6 flex justify-center">
                        <a href="{{ route('instrumen.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Instrumen Kuantitatif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap JS tidak lagi diperlukan karena kita menggunakan Tailwind -->
@endpush