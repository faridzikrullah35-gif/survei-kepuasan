@extends('layouts.app')

@section('title', 'Create Pertanyaan')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@section('main')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Pertanyaan</h1>
            <nav class="flex mt-2 text-sm">
                <a href="{{ route('pertanyaan.index') }}" class="text-blue-600 hover:text-blue-800">Pertanyaan</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-500">Tambahkan Isi Pertanyaan</span>
            </nav>
        </div>

        <!-- Main Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Tambah Pertanyaan</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('pertanyaan.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Standar Selection -->
                    <div>
                        <label for="standar" class="block text-sm font-medium text-gray-700 mb-2">
                            Standar
                        </label>
                        <select 
                            id="standar" 
                            name="standar" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        >
                            <option value="">Pilih Standar</option>
                            @foreach ($standar as $item)
                                <option value="{{ $item->kode }}">{{ $item->nama }}</option>
                            @endforeach
                            <option value="new">Tambah Standar</option>
                        </select>
                        @error('standar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Standar Input (Hidden by default) -->
                    <div id="new-standar-group" class="hidden">
                        <label for="new_standar" class="block text-sm font-medium text-gray-700 mb-2">
                            Input Standar
                        </label>
                        <input 
                            type="text" 
                            id="new_standar" 
                            name="new_standar" 
                            placeholder="Input standar"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        >
                        @error('new_standar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pertanyaan Textarea -->
                    <div>
                        <label for="pertanyaan" class="block text-sm font-medium text-gray-700 mb-2">
                            Pertanyaan
                        </label>
                        <textarea 
                            id="pertanyaan" 
                            name="pertanyaan" 
                            rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                            placeholder="Masukkan pertanyaan..."
                        ></textarea>
                        @error('pertanyaan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                        >
                            Tambah Pertanyaan
                        </button>
                        
                        <a 
                            href="{{ route('edit-standar.index') }}" 
                            class="px-6 py-2 bg-amber-500 text-white font-medium rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors text-center"
                        >
                            Edit & Hapus Standar
                        </a>

                        <a 
                            href="{{ route('pertanyaan.index') }}" 
                            class="px-6 py-2 bg-gray-500 text-white font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-center"
                        >
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const standarDropdown = document.getElementById('standar');
        const newStandarGroup = document.getElementById('new-standar-group');
        const newStandarInput = document.getElementById('new_standar');

        standarDropdown.addEventListener('change', function() {
            if (this.value === 'new') {
                newStandarGroup.classList.remove('hidden');
                newStandarInput.required = true;
            } else {
                newStandarGroup.classList.add('hidden');
                newStandarInput.required = false;
            }
        });
    });
</script>
@endpush