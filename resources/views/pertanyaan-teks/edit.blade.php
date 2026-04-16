@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pertanyaan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('pertanyaan-teks.index') }}">Pertanyaan Teks</a></div>
                <div class="breadcrumb-item">Edit Isi Pertanyaan</div>
            </div>
        </div>

        <div class="section-body">
                <h2 class="section-title">Edit Pertanyaan</h2>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Isi Pertanyaan Baru</h4>
                        </div>

        <form action="{{ route('pertanyaan-teks.update', $pertanyaan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group" style="margin-left: 25px;">
                <p><strong>Nama Standar:</strong> {{ $pertanyaan->standar }}</p>

                <label for="standar">Edit Standar</label>
                <input type="text" class="form-control w-50" id="standar" name="standar" value="{{ old('standar', $pertanyaan->standar) }}">
                    @error('standar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
            </div>

            <div class="form-group" style="margin-left: 20px;">
                <label for="pertanyaan">Pertanyaan</label>
                <textarea class="form-control w-50" id="pertanyaan" name="pertanyaan" rows="3" style="resize: none;">{{ $pertanyaan->pertanyaan }}</textarea>
                    @error('pertanyaan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
            </div>

            <!-- Input untuk Relasi Survei -->
            @foreach ($pertanyaan->surveiTeks as $survei)
            <div class="form-group" style="margin-left: 25px;">
                <p><strong>Edit Survei:</strong></p>
            </div>
            <div class="form-group" style="margin-left: 25px;">
                <label for="survei-{{ $survei->id }}">Survei Standar</label>
                <input type="hidden" name="survei[{{ $survei->id }}][id]" value="{{ $survei->id }}">
                <input type="text" class="form-control w-50" id="survei-{{ $survei->id }}-standar" name="survei[{{ $survei->id }}][standar]" value="{{ $survei->standar }}">
            </div>
            <div class="form-group" style="margin-left: 25px;">
                <label for="survei-{{ $survei->id }}-pertanyaan">Survei Pertanyaan</label>
                <input type="text" class="form-control w-50" id="survei-{{ $survei->id }}-pertanyaan" name="survei[{{ $survei->id }}][pertanyaan]" value="{{ $survei->pertanyaan }}">
            </div>
            @endforeach

            <div class="text-start" style="margin: 20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <a href="{{ route('pertanyaan-teks.index') }}" class="btn btn-danger" style="margin-left: 10px;">Kembali</a>
            </div>
        </form>

        @if(session('success'))
            <div id="success-message" class="alert alert-success minimal-alert">
                {{ session('success') }}
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen input standar utama
        const standarInput = document.getElementById('standar');

        // Periksa apakah input standar utama ada di halaman
        if (standarInput) {
            // Menambahkan event listener untuk perubahan pada input standar
            standarInput.addEventListener('input', function() {
                // Ambil semua input survei standar
                const surveiStandarInputs = document.querySelectorAll('[name^="survei"][name$="[standar]"]');

                // Setel nilai semua input survei standar dengan nilai dari input standar utama
                surveiStandarInputs.forEach(function(input) {
                    input.value = standarInput.value;
                });
            });
        }
    });
</script>

<script>
    // Ketika pengguna mengetik di input Pertanyaan
    document.getElementById('pertanyaan').addEventListener('input', function() {
        // Ambil nilai dari input Pertanyaan
        var pertanyaanValue = this.value;

        // Loop melalui setiap input Survei Pertanyaan dan set nilainya sesuai dengan input Pertanyaan
        @foreach ($pertanyaan->surveiTeks as $survei)
            document.getElementById('survei-{{ $survei->id }}-pertanyaan').value = pertanyaanValue;
        @endforeach
    });
</script>
@endpush