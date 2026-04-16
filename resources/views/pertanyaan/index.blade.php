@extends('layouts.app')

@section('title', 'Pertanyaan')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pertanyaan.css') }}">
@endpush

@section('main')
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6 sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pertanyaan</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola semua pertanyaan untuk survei kepuasan</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('pertanyaan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Pertanyaan
                </a>
            </div>
        </div>

        <!-- Pesan Sukses dan Error -->
        @if(session('success'))
            <div id="success-message" class="rounded-md bg-green-50 p-4 mb-6 border-l-4 border-green-400">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" onclick="this.closest('.bg-green-50').remove()" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="error-message" class="rounded-md bg-red-50 p-4 mb-6 border-l-4 border-red-400">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" onclick="this.closest('.bg-red-50').remove()" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Card Table -->
        <div class="card-modern bg-white overflow-hidden">
            <div class="card-header-modern px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Data Pertanyaan</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Berikut adalah daftar semua pertanyaan yang tersedia dalam sistem.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 5%;">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 25%;">
                                Standar
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 50%;">
                                Pertanyaan
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 20%;">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pertanyaans as $index => $pertanyaan)
                            <tr id="row-{{ $pertanyaan->id }}" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pertanyaans->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $pertanyaan->standar }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $pertanyaan->pertanyaan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <button type="button" class="btn-action btn-add" onclick="openModal('nilaiKeteranganModal-{{ $pertanyaan->id }}')" title="Tambah Nilai Survei">
                                            <i class="fas fa-plus"></i>
                                        </button>

                                        <a href="{{ route('pertanyaan.edit', $pertanyaan->id) }}" class="btn-action btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('pertanyaan.destroy', $pertanyaan->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox empty-state-icon"></i>
                                        <p class="mt-2 text-sm text-gray-500">Tidak ada data pertanyaan.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('pertanyaan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                                </svg>
                                                Tambah Pertanyaan Baru
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:justify-between">
            
            <div class="text-sm text-gray-600">
                Menampilkan {{ $pertanyaans->firstItem() }} - {{ $pertanyaans->lastItem() }} 
                dari {{ $pertanyaans->total() }} data
            </div>

            <div class="overflow-x-auto">
                {{ $pertanyaans->withQueryString()->links() }}
            </div>

        </div>

        @include('pertanyaan.modal-pertanyaan')
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Fungsi untuk membuka modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Mencegah background scroll
        }
    }

    // Fungsi untuk menutup modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Kembalikan scroll background
        }
    }

    // Event listener untuk menutup modal dengan tombol close
    document.addEventListener('DOMContentLoaded', function() {
        // Menutup modal dengan tombol close
        const closeButtons = document.querySelectorAll('[data-bs-dismiss="modal"]');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('.modal');
                if (modal) {
                    closeModal(modal.id);
                }
            });
        });

        // Menutup modal dengan klik di luar modal
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        });

        // Menutup modal dengan tombol ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.show');
                modals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    });

    // Fungsi notifikasi yang lebih modern
    function showNotification(message, type) {
        const notificationId = 'notification-' + Date.now();
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const notificationClass = type === 'success' ? 'notification-success' : 'notification-error';
        
        const notification = $(`
            <div id="${notificationId}" class="notification ${notificationClass}">
                <i class="fas ${iconClass}"></i>
                <span>${message}</span>
            </div>
        `);
        
        $('body').append(notification);
        
        // Animasi muncul
        setTimeout(() => {
            notification.addClass('show');
        }, 10);
        
        // Animasi menghilang
        setTimeout(() => {
            notification.removeClass('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    $(document).on('submit', 'form[id^="formNilai-"]', function (e) {
        e.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: formData,
            success: function (response) {
                if (response.success) {
                    var pertanyaanId = form.find('input[name="pertanyaan_id"]').val();
                    let rowCount = $('#nilaiList-' + pertanyaanId + ' tr').not('#noDataRow').length;
                    var newRow = `<tr id="nilai-${response.id}">
                        <td>${rowCount + 1}</td>
                        <td><span class="badge-value badge-${response.nilai}">${response.nilai}</span></td>
                        <td>${response.keterangan}</td>
                        <td>
                            <button class="btn-action btn-delete" onclick="deleteNilai(${response.id})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;
                    
                    const noDataRow = $('#noDataRow');
                    if (noDataRow.length) {
                        noDataRow.remove();
                    }

                    $('#nilaiList-' + pertanyaanId).append(newRow);
                    form[0].reset();
                    
                    // Ganti alert dengan notifikasi modern
                    showNotification('Nilai berhasil disimpan!', 'success');
                } else {
                    showNotification('Gagal menyimpan nilai.', 'error');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                showNotification('Terjadi kesalahan saat menyimpan nilai.', 'error');
            }
        });
    });

    // Function to add new 'nilai' via AJAX
    function addNilai(pertanyaanId) {
        let nilai = $('#nilaiInput').val();
        let keterangan = $('#keteranganInput').val();

        $.ajax({
            url: '/path/to/store/nilai',
            method: 'POST',
            data: {
                pertanyaan_id: pertanyaanId,
                nilai: nilai,
                keterangan: keterangan,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                let rowCount = $('#nilaiList-' + pertanyaanId + ' tr').not('#noDataRow').length;
                let newRow = `
                    <tr id="nilai-${response.id}">
                        <td>${rowCount + 1}</td>
                        <td><span class="badge-value badge-${response.nilai}">${response.nilai}</span></td>
                        <td>${response.keterangan}</td>
                        <td>
                            <button class="btn-action btn-delete" onclick="deleteNilai(${response.id})" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#nilaiList-' + pertanyaanId).append(newRow);
                showNotification('Nilai berhasil ditambahkan!', 'success');
            },
            error: function(error) {
                console.log('Error:', error);
                showNotification('Gagal menambahkan nilai.', 'error');
            }
        });
    }

    // Function to delete a 'nilai'
    function deleteNilai(nilaiId) {
        if (!confirm("Apakah Anda yakin ingin menghapus?")) return;

        $.ajax({
            type: 'DELETE',
            url: '/nilai/' + nilaiId,
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#nilai-' + nilaiId).fadeOut(300, function() { 
                        $(this).remove(); 
                        
                        // Periksa apakah tabel sudah kosong
                        const tableBody = $('#nilaiList-' + response.pertanyaan_id);
                        if (tableBody.children().length === 0) {
                            const noDataRow = `<tr id="noDataRow">
                                <td colspan="4" class="text-center">Belum ada data nilai.</td>
                            </tr>`;
                            tableBody.append(noDataRow);
                        } else {
                            // Update nomor urut di tabel
                            tableBody.find('tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                        }
                    });
                    showNotification('Data berhasil dihapus!', 'success');
                }
            },
            error: function() {
                showNotification('Gagal menghapus data', 'error');
            }
        });
    }
</script>
@endpush