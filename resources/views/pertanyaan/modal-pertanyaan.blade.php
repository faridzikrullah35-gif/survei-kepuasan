@foreach($pertanyaans as $pertanyaan)
    <div class="modal fade" id="nilaiKeteranganModal-{{ $pertanyaan->id }}" tabindex="-1" role="dialog" aria-labelledby="nilaiKeteranganModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 550px;">
            <div class="modal-content bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="modal-header bg-gradient-to-r from-blue-500 to-blue-600 text-white py-4 px-6 border-b-0">
                    <h5 class="modal-title font-semibold text-lg" id="nilaiKeteranganModalLabel-{{ $pertanyaan->id }}">Nilai & Keterangan</h5>
                    <button type="button" class="btn-close text-white opacity-80 hover:opacity-100 transition-opacity" onclick="closeModal('nilaiKeteranganModal-{{ $pertanyaan->id }}')" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body p-6" style="max-height: 70vh; overflow-y: auto;">
                    <!-- Informasi Pertanyaan -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-4 border-l-4 border-blue-400">
                        <div class="mb-2">
                            <span class="text-sm font-medium text-gray-500">Standar Pertanyaan:</span>
                            <p class="text-gray-800 font-medium">{{ $pertanyaan->standar }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Pertanyaan:</span>
                            <p class="text-gray-800 font-medium">{{ $pertanyaan->pertanyaan }}</p>
                        </div>
                    </div>

                    <!-- Form untuk Simpan Nilai -->
                    <form id="formNilai-{{ $pertanyaan->id }}" action="{{ route('nilai.store') }}" method="POST" class="space-y-4">                                                    
                        @csrf
                        <input type="hidden" name="pertanyaan_id" value="{{ $pertanyaan->id }}">
                        
                        <div>
                            <label for="nilai-{{ $pertanyaan->id }}" class="block text-sm font-medium text-gray-700 mb-2">Nilai</label>
                            <select class="form-select w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="nilai" id="nilai-{{ $pertanyaan->id }}" required>
                                <option value="" selected>Pilih Nilai</option>
                                <option value="1">1 - Sangat Kurang</option>
                                <option value="2">2 - Kurang</option>
                                <option value="3">3 - Baik</option>
                                <option value="4">4 - Sangat Baik</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="keterangan-{{ $pertanyaan->id }}" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <textarea class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="keterangan" id="keterangan-{{ $pertanyaan->id }}" rows="3" placeholder="Masukkan keterangan..." required></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200 flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Nilai
                            </button>
                        </div>                                                    
                    </form>
                    
                    <!-- Tabel Nilai & Keterangan -->
                    <div class="mt-6 overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="nilaiList-{{ $pertanyaan->id }}">
                                @if($pertanyaan->nilai->isNotEmpty())
                                    @foreach($pertanyaan->nilai as $nilai)
                                        <tr id="nilai-{{ $nilai->id }}" class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($nilai->nilai == 1) bg-red-100 text-red-800
                                                    @elseif($nilai->nilai == 2) bg-orange-100 text-orange-800
                                                    @elseif($nilai->nilai == 3) bg-blue-100 text-blue-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    {{ $nilai->nilai }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $nilai->keterangan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <button class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50 transition-colors duration-200" onclick="deleteNilai({{ $nilai->id }})" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="noDataRow">
                                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                            <i class="fas fa-inbox text-3xl mb-2 block text-gray-300"></i>
                                            Belum ada data nilai.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-gray-50 py-3 px-6 border-t">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200" onclick="closeModal('nilaiKeteranganModal-{{ $pertanyaan->id }}')">
                        <i class="fas fa-times mr-2"></i>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
/* Modal Styles - Perbaikan untuk mencegah modal muncul bersamaan */
.modal {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    z-index: 1055 !important;
    display: none !important;
    width: 100% !important;
    height: 100% !important;
    overflow-x: hidden !important;
    overflow-y: auto !important;
    outline: 0 !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
}

.modal.show {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.modal-dialog {
    position: relative !important;
    margin: 1.75rem auto !important;
    max-width: 90% !important;
    width: 550px !important;
    pointer-events: auto !important;
    z-index: 1060 !important;
}

@media (min-width: 768px) {
    .modal.show .modal-dialog {
        margin: 0 !important;
    }
}

@media (max-width: 576px) {
    .modal-dialog {
        max-width: 95% !important;
        margin: 1rem auto !important;
    }
    
    .modal-body {
        padding: 1rem !important;
    }
    
    .table th, .table td {
        padding: 0.5rem !important;
    }
    
    .modal-footer {
        padding: 0.75rem 1rem !important;
    }
}

/* Form Styles */
.form-control, .form-select {
    border: 1px solid #d1d5db !important;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
}

/* Button Styles */
.btn-close {
    background: transparent !important;
    border: none !important;
    font-size: 1.5rem !important;
    color: white !important;
    opacity: 0.8 !important;
    cursor: pointer !important;
}

.btn-close:hover {
    opacity: 1 !important;
}
</style>

<script>
// Fungsi untuk membuka modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Mencegah background scroll
    }
}

// ❌ ESC MASIH BISA NUTUP
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            closeModal(modal.id);
        });
    }
});

</script>