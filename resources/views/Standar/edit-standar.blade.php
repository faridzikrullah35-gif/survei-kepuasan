@extends('layouts.app')

@section('title', 'Edit & Hapus Standar Survei')

@section('main')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit & Hapus Standar Survei</h1>
            <nav class="flex mt-2 text-sm">
                <a href="{{ route('pertanyaan.create') }}" class="text-blue-600 hover:text-blue-800">Pertanyaan Create</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-500">Edit & Hapus Standar Survei</span>
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
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Daftar Standar Survei</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola standar Anda di sini.</p>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode Standar
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Standar
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($standar as $index => $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->kode }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <span id="nama-standar-{{ $item->kode }}">{{ $item->nama }}</span>
                                        <input type="text" class="hidden w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="edit-input-{{ $item->kode }}" value="{{ $item->nama }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <button type="button" class="edit-btn px-3 py-1.5 bg-amber-500 text-white rounded hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="submit" class="save-btn hidden px-3 py-1.5 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors" data-kode="{{ $item->kode }}">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button type="button" class="cancel-btn hidden px-3 py-1.5 bg-gray-500 text-white rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors" data-kode="{{ $item->kode }}">
                                                <i class="fas fa-times"></i> Batal
                                            </button>

                                            <!-- Delete Form -->
                                            <form action="{{ route('standar.destroy', $item->kode) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus standar ini?')">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data standar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener untuk tombol edit
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const kode = this.dataset.kode;
                const namaStandarSpan = document.getElementById(`nama-standar-${kode}`);
                const editInput = document.getElementById(`edit-input-${kode}`);
                const saveBtn = document.querySelector(`.save-btn[data-kode="${kode}"]`);
                const cancelBtn = document.querySelector(`.cancel-btn[data-kode="${kode}"]`);

                // Sembunyikan nama standar dan tampilkan input
                namaStandarSpan.classList.add('hidden');
                editInput.classList.remove('hidden');
                editInput.focus();

                // Sembunyikan tombol edit dan tampilkan tombol simpan/batal
                this.classList.add('hidden');
                saveBtn.classList.remove('hidden');
                cancelBtn.classList.remove('hidden');
            });
        });

        // Event listener untuk tombol simpan
        document.querySelectorAll('.save-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const kode = this.dataset.kode;
                const editInput = document.getElementById(`edit-input-${kode}`);
                const newNama = editInput.value;

                fetch(`/standar/update-from-table/${kode}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ nama: newNama })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`nama-standar-${kode}`).textContent = newNama;
                        document.getElementById(`nama-standar-${kode}`).classList.remove('hidden');
                        document.getElementById(`edit-input-${kode}`).classList.add('hidden');

                        document.querySelector(`.edit-btn[data-kode="${kode}"]`).classList.remove('hidden');
                        document.querySelector(`.save-btn[data-kode="${kode}"]`).classList.add('hidden');
                        document.querySelector(`.cancel-btn[data-kode="${kode}"]`).classList.add('hidden');

                        // Tampilkan pesan sukses
                        const successDiv = document.createElement('div');
                        successDiv.id = 'success-message';
                        successDiv.className = 'fixed top-4 right-4 z-50 px-6 py-3 bg-green-100 border border-green-400 text-green-700 rounded-md shadow-md transition-all duration-500 transform translate-x-0';
                        successDiv.innerHTML = `
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                ${data.message}
                            </div>
                        `;
                        document.body.appendChild(successDiv);
                        
                        setTimeout(function() {
                            successDiv.classList.add('translate-x-full', 'opacity-0');
                            setTimeout(() => successDiv.remove(), 500);
                        }, 3000);
                    } else {
                        // Tampilkan pesan error
                        const errorDiv = document.createElement('div');
                        errorDiv.id = 'error-message';
                        errorDiv.className = 'fixed top-4 right-4 z-50 px-6 py-3 bg-red-100 border border-red-400 text-red-700 rounded-md shadow-md transition-all duration-500 transform translate-x-0';
                        errorDiv.innerHTML = `
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                ${data.message}
                            </div>
                        `;
                        document.body.appendChild(errorDiv);
                        
                        setTimeout(function() {
                            errorDiv.classList.add('translate-x-full', 'opacity-0');
                            setTimeout(() => errorDiv.remove(), 500);
                        }, 3000);
                    }
                })
                .catch(error => {
                    // Tampilkan pesan error
                    const errorDiv = document.createElement('div');
                    errorDiv.id = 'error-message';
                    errorDiv.className = 'fixed top-4 right-4 z-50 px-6 py-3 bg-red-100 border border-red-400 text-red-700 rounded-md shadow-md transition-all duration-500 transform translate-x-0';
                    errorDiv.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Terjadi kesalahan saat memperbarui standar.
                        </div>
                    `;
                    document.body.appendChild(errorDiv);
                    
                    setTimeout(function() {
                        errorDiv.classList.add('translate-x-full', 'opacity-0');
                        setTimeout(() => errorDiv.remove(), 500);
                    }, 3000);
                });
            });
        });

        // Event listener untuk tombol batal
        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', function() {
                const kode = this.dataset.kode;
                const namaStandarSpan = document.getElementById(`nama-standar-${kode}`);
                const editInput = document.getElementById(`edit-input-${kode}`);
                const saveBtn = document.querySelector(`.save-btn[data-kode="${kode}"]`);
                const editBtn = document.querySelector(`.edit-btn[data-kode="${kode}"]`);

                // Tampilkan kembali nama standar dan sembunyikan input
                namaStandarSpan.classList.remove('hidden');
                editInput.classList.add('hidden');

                // Tampilkan kembali tombol edit dan sembunyikan tombol simpan/batal
                editBtn.classList.remove('hidden');
                saveBtn.classList.add('hidden');
                this.classList.add('hidden');
            });
        });
    });
</script>
@endpush