@extends('layouts.app')

@section('title', 'Import Pengguna')

@section('main')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Halaman -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Import Pengguna</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-500 md:ml-2">Import Pengguna</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ route('usermanagement') }}" class="mb-6 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Manajemen Pengguna
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Kartu Kiri: Form Import -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        Unggah File Excel
                    </h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="importForm">
                        @csrf
                        <div>
                            <label for="file_excel" class="block text-sm font-medium text-gray-700">Pilih File Excel (.xlsx)</label>
                            
                            <!-- Area Upload dengan Preview -->
                            <div class="mt-1">
                                <!-- Drop Zone -->
                                <div x-data="{ 
                                    fileName: null,
                                    fileSize: null,
                                    isDragging: false,
                                    handleFile(file) {
                                        if (file) {
                                            const validTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
                                            if (!validTypes.includes(file.type) && !file.name.endsWith('.xlsx') && !file.name.endsWith('.xls')) {
                                                showToast('error', 'Mohon pilih file Excel (.xlsx atau .xls)');
                                                return;
                                            }
                                            if (file.size > 10 * 1024 * 1024) {
                                                showToast('error', 'Ukuran file maksimal 10MB');
                                                return;
                                            }
                                            this.fileName = file.name;
                                            this.fileSize = (file.size / 1024).toFixed(2) + ' KB';
                                            
                                            // Update input file
                                            const input = document.getElementById('file_excel');
                                            const dataTransfer = new DataTransfer();
                                            dataTransfer.items.add(file);
                                            input.files = dataTransfer.files;
                                            
                                            // Trigger change event
                                            input.dispatchEvent(new Event('change'));
                                            
                                            showToast('success', 'File berhasil dipilih: ' + file.name);
                                        }
                                    },
                                    removeFile() {
                                        this.fileName = null;
                                        this.fileSize = null;
                                        const input = document.getElementById('file_excel');
                                        input.value = '';
                                        input.dispatchEvent(new Event('change'));
                                        showToast('info', 'File telah dihapus');
                                    }
                                }" 
                                x-init="
                                    document.getElementById('file_excel').addEventListener('change', function(e) {
                                        if (this.files.length > 0) {
                                            const file = this.files[0];
                                            fileName = file.name;
                                            fileSize = (file.size / 1024).toFixed(2) + ' KB';
                                        }
                                    });
                                "
                                class="relative">
                                
                                    <!-- Drop Zone Container -->
                                    <div 
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="
                                            isDragging = false;
                                            if (event.dataTransfer.files.length > 0) {
                                                handleFile(event.dataTransfer.files[0]);
                                            }
                                        "
                                        :class="{
                                            'border-indigo-400 bg-indigo-50': isDragging,
                                            'border-gray-300': !isDragging
                                        }"
                                        class="flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md hover:border-indigo-400 transition-colors duration-300"
                                    >
                                        <!-- Tampilan Default (Belum Ada File) -->
                                        <div x-show="!fileName" class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="file_excel" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Unggah file</span>
                                                    <input id="file_excel" name="file" type="file" class="sr-only" accept=".xlsx,.xls" required>
                                                </label>
                                                <p class="pl-1">atau seret dan lepas di sini</p>
                                            </div>
                                            <p class="text-xs text-gray-500">XLSX / XLS hingga 10MB</p>
                                        </div>

                                        <!-- Preview File (Sudah Ada File) -->
                                        <div x-show="fileName" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="w-full">
                                            <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg">
                                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate" x-text="fileName"></p>
                                                        <p class="text-xs text-gray-500" x-text="fileSize"></p>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ml-2">
                                                    <button type="button" @click="removeFile()" class="inline-flex items-center p-1.5 border border-transparent rounded-full text-gray-400 hover:text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="mt-2 text-xs text-green-600 text-center">✓ File siap diupload</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('file')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" id="submitBtn" disabled>
                                <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                                Import Data Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kartu Kanan: Panduan & Template -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Panduan & Template
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">1. Unduh Template</h3>
                        <p class="text-sm text-gray-600">Gunakan template Excel yang telah kami sediakan untuk memastikan format data Anda benar.</p>
                        <a href="{{ asset('template/contoh-import-user.xlsx') }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Template Excel
                        </a>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">2. Isi Data Pengguna</h3>
                        <p class="text-sm text-gray-600">Pastikan data Anda mengikuti format kolom berikut:</p>
                        <div class="mt-2 p-3 bg-gray-50 rounded-md">
                            <code class="text-sm text-gray-800">name | email | password | role</code>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">3. Contoh Format</h3>
                        <div class="mt-2 border-2 border-gray-200 rounded-lg overflow-hidden">
                            <img src="{{ asset('img/contoh-excel-user.png') }}" alt="Contoh Format Excel" class="w-full h-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Toastr dari CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Script untuk enable/disable tombol submit, validasi, dan toastr -->
<script>
// Global showToast function yang bisa dipanggil dari mana saja
function showToast(type, message, title = '') {
    // Pastikan toastr sudah tersedia
    if (typeof toastr !== 'undefined') {
        switch(type) {
            case 'success':
                toastr.success(message, title || 'Berhasil!');
                break;
            case 'error':
                toastr.error(message, title || 'Terjadi Kesalahan!');
                break;
            case 'warning':
                toastr.warning(message, title || 'Peringatan!');
                break;
            case 'info':
                toastr.info(message, title || 'Informasi');
                break;
            default:
                toastr.info(message);
        }
    } else {
        // Fallback ke alert jika toastr belum siap
        alert(message);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file_excel');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('importForm');
    
    // Function to check if file is selected
    function checkFile() {
        if (fileInput.files.length > 0) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
    
    // Initial check
    checkFile();
    
    // Listen for changes
    fileInput.addEventListener('change', checkFile);

    // Toastr configuration
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        // Check if file is selected
        if (!fileInput.files.length) {
            e.preventDefault();
            showToast('warning', 'Silakan pilih file terlebih dahulu');
            return;
        }

        // Validate file extension
        const file = fileInput.files[0];
        const validExtensions = ['.xlsx', '.xls'];
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
        
        if (!validExtensions.includes(fileExtension)) {
            e.preventDefault();
            showToast('error', 'Mohon pilih file Excel (.xlsx atau .xls)');
            return;
        }

        // Validate file size (max 10MB)
        if (file.size > 10 * 1024 * 1024) {
            e.preventDefault();
            showToast('error', 'Ukuran file maksimal 10MB');
            return;
        }

        // Show loading toastr
        showToast('info', 'Sedang mengimpor data...', 'Mohon Tunggu');
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;
    });

    // Handle session messages from Laravel
    @if(session('success'))
        // Gunakan setTimeout untuk memastikan toastr sudah siap
        setTimeout(function() {
            showToast('success', @json(session('success')));
        }, 500);
    @endif

    @if(session('error'))
        setTimeout(function() {
            showToast('error', @json(session('error')));
        }, 500);
    @endif

    @if($errors->any())
        setTimeout(function() {
            @foreach($errors->all() as $error)
                showToast('error', @json($error), 'Validasi Gagal');
            @endforeach
        }, 500);
    @endif
});
</script>
@endsection