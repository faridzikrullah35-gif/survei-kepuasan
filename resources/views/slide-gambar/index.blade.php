@extends('layouts.app') <!-- Sesuaikan dengan layout yang Anda gunakan -->

@section('title', 'Landing Slide Gambar')

@section('main')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Slide Gambar</h1>
        <button id="btnTambah" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i>Tambah Slide
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($slides as $slide)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $imagePath = $slide->image ?? '';
                            $exists = $imagePath && Storage::disk('public')->exists($imagePath);
                            $base64 = null;
                            
                            if ($exists) {
                                $fullPath = storage_path('app/public/' . $imagePath);
                                $imageData = file_get_contents($fullPath);
                                $mime = mime_content_type($fullPath);
                                $base64 = 'data:' . $mime . ';base64,' . base64_encode($imageData);
                            }
                        @endphp
                        
                        @if($exists && $base64)
                            <img src="{{ $base64 }}" alt="{{ $slide->title }}" class="h-12 w-16 object-cover rounded">
                        @else
                            <div class="h-12 w-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">
                                No Image
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $slide->order }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded {{ $slide->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $slide->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button class="btn-edit text-blue-600 hover:text-blue-900 mr-2" data-id="{{ $slide->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete text-red-600 hover:text-red-900" data-id="{{ $slide->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada slide.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL CREATE & EDIT (Satu Modal Dua Mode) -->
<div id="slideModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalOverlay"></div>

        <!-- Modal Panel -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto z-10">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 id="modal-title" class="text-lg font-medium text-gray-900">Form Slide</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="slideForm" enctype="multipart/form-data" class="p-4">
                @csrf
                <input type="hidden" id="method" name="_method" value="POST">
                <input type="hidden" id="slide_id" name="slide_id">

                <!-- Field Gambar -->
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                    <input type="file" id="image" name="image" accept="image/*" 
                        class="mt-1 block w-full text-sm text-gray-500 
                                file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 
                                file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                hover:file:bg-blue-100">
                    
                    <!-- Keterangan Validasi -->
                    <p class="mt-1 text-xs text-gray-500">
                        <span class="font-medium">Format:</span> JPG, JPEG, PNG, GIF &nbsp;|&nbsp; 
                        <span class="font-medium">Maks. ukuran:</span> 2 MB
                    </p>
                    
                    <div id="previewContainer" class="mt-2 hidden">
                        <img id="imagePreview" src="" alt="Preview" class="h-24 w-auto object-cover rounded">
                    </div>
                </div>

                <!-- Field Urutan -->
                <div class="mb-4">
                    <label for="order" class="block text-sm font-medium text-gray-700">Urutan</label>
                    <input type="number" id="order" name="order" value="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Field Status Aktif -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif</label>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== DOM Elements ==========
    const modal = document.getElementById('slideModal');
    const form = document.getElementById('slideForm');
    const btnTambah = document.getElementById('btnTambah');
    const closeModal = document.getElementById('closeModal');
    const cancelModal = document.getElementById('cancelModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const submitBtn = document.getElementById('submitBtn');
    const methodInput = document.getElementById('method');
    const slideIdInput = document.getElementById('slide_id');
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const orderInput = document.getElementById('order');
    const isActiveInput = document.getElementById('is_active');
    const modalTitle = document.getElementById('modal-title');

    let isEdit = false;
    let currentSlideId = null;

    // ========== Helper Functions ==========
    function resetForm() {
        form.reset();
        imageInput.value = '';
        previewContainer.classList.add('hidden');
        imagePreview.src = '';
        orderInput.value = 0;
        isActiveInput.checked = true;
        slideIdInput.value = '';
        methodInput.value = 'POST';
        form.action = '{{ route("slides.store") }}';
        submitBtn.textContent = 'Simpan';
        modalTitle.textContent = 'Tambah Slide';
        isEdit = false;
        currentSlideId = null;
    }

    function openModalCreate() {
        resetForm();
        modal.classList.remove('hidden');
    }

    function openModalEdit(id) {
        isEdit = true;
        currentSlideId = id;
        slideIdInput.value = id;
        methodInput.value = 'PUT';
        form.action = '{{ url("slides") }}/' + id;
        submitBtn.textContent = 'Update';
        modalTitle.textContent = 'Edit Slide';

        // Fetch data slide via AJAX
        fetch('/slides/' + id + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal mengambil data');
            return response.json();
        })
        .then(data => {
            orderInput.value = data.order || 0;
            isActiveInput.checked = data.is_active == 1;

            if (data.image) {
                imagePreview.src = data.image;
                previewContainer.classList.remove('hidden');
            } else {
                imagePreview.src = '';
                previewContainer.classList.add('hidden');
            }

            modal.classList.remove('hidden');
        })
        .catch(error => {
            alert('Gagal mengambil data slide: ' + error.message);
            console.error(error);
        });
    }

    function closeModalFunc() {
        modal.classList.add('hidden');
    }

    // ========== Event Listeners ==========

    // Buka modal tambah
    btnTambah.addEventListener('click', openModalCreate);

    // Tutup modal
    closeModal.addEventListener('click', closeModalFunc);
    cancelModal.addEventListener('click', closeModalFunc);
    modalOverlay.addEventListener('click', closeModalFunc);

    // Preview gambar
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
            imagePreview.src = '';
        }
    });

    // Submit form via fetch
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const url = form.action;

        // Jika edit, tambahkan _method PUT
        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Menyimpan...';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {

            const text = await response.text();

            console.log(text);

            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error(text);
            }

        })
        .then(data => {
            if (data.success) {
                alert(data.message || 'Berhasil disimpan.');
                location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMsg = 'Terjadi kesalahan.';
            if (error.errors) {
                errorMsg = Object.values(error.errors).flat().join('\n');
            } else if (error.message) {
                errorMsg = error.message;
            }
            alert(errorMsg);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = isEdit ? 'Update' : 'Simpan';
        });
    });

    // Tombol Edit di tabel
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            openModalEdit(id);
        });
    });

    // Tombol Delete di tabel
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if (confirm('Apakah Anda yakin ingin menghapus slide ini?')) {
                const token = document.querySelector('input[name="_token"]').value;
                fetch('/slides/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message || 'Berhasil dihapus.');
                        location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus.');
                });
            }
        });
    });
});
</script>
@endpush