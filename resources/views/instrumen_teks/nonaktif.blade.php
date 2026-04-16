@extends('layouts.app')

@section('title', 'Instrumen Kualitatif Non-Aktif')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .table-custom {
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }
        .table-custom th, .table-custom td {
            padding: 12px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        .table-custom th {
            background-color: #f8f9fa;
            color: #495057;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .table-container {
            margin-top: 20px;
        }
        .section-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-action {
            margin-top: 15px;
            display: flex;
            justify-content: center;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h6 style="text-align: center; font-size: 20px; margin-bottom: 30px;">Instrumen Kualitatif Non-Aktif</h6>
            </div>

            <!-- Tampilkan tabel instrumen non-aktif -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Tabel Instrumen Kualitatif Non-Aktif</h4>
                        </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-custom">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Akademik</th>
                                    <th>Status</th>
                                    <th>Standar</th>
                                    <th>Pertanyaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($nonaktif as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->tahunAkademikTeks->tahun ?? 'Tidak ada' }}</td> <!-- Tahun Akademik -->
                                        <td><span class="badge badge-danger">{{ $item->status }}</td>
                                        <td>{{ $item->pertanyaanTeks->standar ?? 'Tidak ada' }}</td> <!-- Standar -->
                                        <td>{{ $item->pertanyaanTeks->pertanyaan ?? 'Tidak ada' }}</td> <!-- Pertanyaan -->
                                        <td>
                                            <form action="{{ route('instrumen-teks-non-aktif.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada instrumen non-aktif.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Button for other actions -->
                    <div class="btn-action">
                        <a href="{{ route('instrumen_teks.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Instrumen Kualitatif
                        </a>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
