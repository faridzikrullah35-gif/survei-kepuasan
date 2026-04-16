@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

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
                <span class="text-gray-500">Edit Isi Pertanyaan</span>
            </nav>
        </div>

        <!-- Main Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Edit Pertanyaan</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('pertanyaan.update', $pertanyaan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Current Standar Display -->
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-sm text-gray-600">Standar Saat Ini</p>
                        <p class="text-lg font-medium text-gray-900">{{ $pertanyaan->standar }}</p>
                    </div>
                    
                    <!-- Standar Input -->
                    <div>
                        <label for="standar" class="block text-sm font-medium text-gray-700 mb-2">
                            Edit Standar
                        </label>
                        <input 
                            type="text" 
                            id="standar" 
                            name="standar" 
                            value="{{ old('standar', $pertanyaan->standar) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        >
                        @error('standar')
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
                        >{{ $pertanyaan->pertanyaan }}</textarea>
                        @error('pertanyaan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Hidden Survei Inputs -->
                    @foreach ($pertanyaan->survei as $survei)
                        <input type="hidden" name="survei[{{ $survei->id }}][id]" value="{{ $survei->id }}">
                    @endforeach
                    
                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                        >
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>
                        
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

<!-- Success Message -->
@if(session('success'))
    <div id="success-message" class="fixed bottom-4 right-4 z-50 px-6 py-3 bg-green-100 border border-green-400 text-green-700 rounded-md shadow-md transition-all duration-500 transform translate-x-0">
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
@endsection