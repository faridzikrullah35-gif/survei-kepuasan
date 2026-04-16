@extends('layouts.app')

@section('title', 'Data Jawaban')

@push('style')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .btn {
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }
        tbody tr {
            transition: background-color 0.2s ease;
        }
        tbody tr:hover {
            background-color: #f9fafb;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tbody tr:nth-child(even):hover {
            background-color: #f3f4f6;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        }
        .stat-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .badge-answer {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .filter-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .breadcrumb {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            display: inline-flex;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('main')
    <div class="main-content p-4 md:p-6 lg:p-8 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <section class="section mb-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    <i class="fas fa-comments mr-3"></i>Data Jawaban
                </h1>
                <div class="breadcrumb flex justify-center text-sm">
                    <div class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 transition-colors flex items-center">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                    </div>
                    <div class="mx-3 text-gray-400">/</div>
                    <div class="breadcrumb-item">
                        <a href="{{ route('instrumen_teks.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors flex items-center">
                            <i class="fas fa-file-alt mr-2"></i>Instrumen Kualitatif
                        </a>
                    </div>
                    <div class="mx-3 text-gray-400">/</div>
                    <div class="breadcrumb-item">
                        <span class="text-gray-600 font-medium flex items-center">
                            <i class="fas fa-database mr-2"></i>Data Jawaban
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mx-auto px-4">
            <!-- Filter Section -->
            <div class="flex justify-center mb-8">
                <div class="w-full lg:w-4/5 xl:w-3/4">
                    <div class="card bg-white rounded-xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-filter mr-2"></i>
                                Filter Data Jawaban
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="filter-section">
                                <p class="text-sm text-gray-600 mb-4 flex items-center">
                                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                    Pilih filter untuk menampilkan data jawaban instrumen kualitatif
                                </p>
                                <form action="{{ route('jawaban.index') }}" method="GET">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="form-group">
                                            <label for="tahun_akademik_teks_id" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-calendar-alt mr-1 text-blue-500"></i>
                                                Pilih Tahun Akademik
                                            </label>
                                            <select name="tahun_akademik_teks_id" id="tahun_akademik_teks_id" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                                <option value="">Pilih Tahun Akademik</option>
                                                @foreach($tahunAkademikTeks as $tahun)
                                                    @if($tahun->status == 'Aktif')    
                                                        <option value="{{ $tahun->id }}" {{ request('tahun_akademik_teks_id') == $tahun->id ? 'selected' : '' }}>
                                                            {{ $tahun->tahun }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="instrumen_teks_id" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-question-circle mr-1 text-purple-500"></i>
                                                Pilih Data Pertanyaan Kualitatif
                                            </label>
                                            <select name="instrumen_teks_id" id="instrumen_teks_id" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                                <option value="">Pilih Data Pertanyaan Kualitatif</option>
                                                @foreach($instrumenTeks as $item)
                                                    <option value="{{ $item->id }}" 
                                                            {{ request('instrumen_teks_id') == $item->id ? 'selected' : '' }}>
                                                        {{ Str::limit($item->pertanyaanTeks->pertanyaan, 50) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-3 mt-6 justify-end">
                                        <button type="submit" class="btn px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <i class="fas fa-search mr-2"></i>Filter
                                        </button>
                                        <button type="button" class="btn px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500" id="printButton">
                                            <i class="fas fa-print mr-2"></i>Cetak
                                        </button>
                                        <button type="button" class="btn px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500" onclick="exportToExcel()">
                                            <i class="fas fa-file-excel mr-2"></i>Export ke Excel
                                        </button>
                                        <a href="{{ route('jawaban.index') }}" class="btn px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            <i class="fas fa-redo mr-2"></i>Reset
                                        </a>
                                    </div>
                                </form>
                            </div>

                            <!-- Alert Message -->
                            <div id="alert-message" class="alert p-4 bg-yellow-100 border-l-4 border-yellow-400 text-yellow-700 rounded-lg mt-6 hidden">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <span id="alert-text"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            @if(request('instrumen_teks_id') && $jawaban && $jawaban->isNotEmpty())
                <div class="flex justify-center mb-8">
                    <div class="w-full lg:w-4/5 xl:w-3/4">
                        <div class="card bg-white rounded-xl shadow-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                                <h2 class="text-xl font-semibold text-white flex items-center">
                                    <i class="fas fa-table mr-2"></i>
                                    Daftar Data Jawaban Instrumen Kualitatif
                                </h2>
                            </div>
                            <div class="p-6">
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                                    <p class="text-sm flex items-center">
                                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                        Menampilkan <strong>{{ $jawaban->count() }}</strong> jawaban untuk pertanyaan yang dipilih
                                    </p>
                                </div>
                                <div class="table-container">
                                    <table id="jawaban-table" class="w-full">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 text-left">No</th>
                                                <th class="px-4 py-3 text-left">Tahun Akademik</th>
                                                <th class="px-4 py-3 text-left">Standar</th>
                                                <th class="px-4 py-3 text-left">Pertanyaan</th>
                                                <th class="px-4 py-3 text-left">Jawaban</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jawaban as $index => $item)
                                                <tr class="border-b">
                                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                                    <td class="px-4 py-3">
                                                        <span class="px-2 py-1 bg-gray-100 rounded-full text-xs font-semibold">
                                                            {{ $item->tahunAkademikTeks->tahun ?? 'Tidak ada' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                                            {{ $item->pertanyaanTeks->standar ?? 'Tidak ada' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 max-w-xs">
                                                        <div class="truncate" title="{{ $item->pertanyaanTeks->pertanyaan ?? 'Tidak ada' }}">
                                                            {{ $item->pertanyaanTeks->pertanyaan ?? 'Tidak ada' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="badge-answer" title="{{ $item->jawaban ?? 'Tidak ada' }}">
                                                            {{ $item->jawaban ?? 'Tidak ada' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @if(request('instrumen_teks_id'))
                    <div class="flex justify-center mb-8">
                        <div class="w-full lg:w-4/5 xl:w-3/4">
                            <div class="card bg-white rounded-xl shadow-xl overflow-hidden">
                                <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                                    <h2 class="text-xl font-semibold text-white flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Informasi
                                    </h2>
                                </div>
                                <div class="p-6">
                                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                        <p class="text-sm flex items-center">
                                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                            Tidak ada data jawaban untuk filter yang dipilih.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Statistics Section -->
            <div class="flex justify-center">
                <div class="w-full lg:w-4/5 xl:w-3/4">
                    <div class="card bg-white rounded-xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Statistik Jawaban
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="stat-card rounded-lg p-6 text-center">
                                    <i class="fas fa-comments text-4xl mb-3"></i>
                                    <h3 class="text-lg font-semibold mb-1">Total Jawaban</h3>
                                    <p class="text-3xl font-bold">{{ $jawaban->count() }}</p>
                                </div>
                                <div class="stat-card stat-card-2 rounded-lg p-6 text-center">
                                    <i class="fas fa-calendar-check text-4xl mb-3"></i>
                                    <h3 class="text-lg font-semibold mb-1">Tahun Aktif</h3>
                                    <p class="text-3xl font-bold">{{ $tahunAkademikTeks->where('status', 'Aktif')->count() }}</p>
                                </div>
                                <div class="stat-card stat-card-3 rounded-lg p-6 text-center">
                                    <i class="fas fa-question-circle text-4xl mb-3"></i>
                                    <h3 class="text-lg font-semibold mb-1">Total Pertanyaan</h3>
                                    <p class="text-3xl font-bold">{{ $instrumenTeks->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Library SheetJS (xlsx) untuk export Excel -->
<script src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterSelected = document.querySelector('#instrumen_teks_id').value;
        const jawabanTable = document.querySelector('#jawaban-table');
        const alertMessage = document.querySelector('#alert-message');
        const alertText = document.querySelector('#alert-text');

        // Sembunyikan tabel jika tidak ada filter yang dipilih atau tidak ada data
        if (jawabanTable) {
            jawabanTable.classList.add('hidden');
        }

        // Jika filter belum dipilih, tampilkan pesan untuk memilih filter
        if (!filterSelected) {
            if (alertMessage) {
                alertMessage.classList.remove('hidden');
                alertText.textContent = 'Silakan pilih filter untuk menampilkan data jawaban.';
            }
        } else {
            // Jika ada filter, cek apakah ada data
            if (jawabanTable) {
                const tableBody = jawabanTable.querySelector('tbody');
                if (tableBody && tableBody.rows.length === 0) {
                    if (alertMessage) {
                        alertMessage.classList.remove('hidden');
                        alertMessage.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                        alertMessage.classList.remove('bg-yellow-100', 'border-yellow-400', 'text-yellow-700');
                        alertText.textContent = 'Tidak ada data untuk filter ini.';
                    }
                } else {
                    jawabanTable.classList.remove('hidden');
                    if (alertMessage) {
                        alertMessage.classList.add('hidden');
                    }
                }
            }
        }
    });
</script>

<script>
    document.getElementById('printButton').addEventListener('click', function () {
        const jawabanTable = document.getElementById('jawaban-table');
        
        if (!jawabanTable || jawabanTable.classList.contains('hidden')) {
            // Tampilkan pesan error yang lebih baik
            const alertMessage = document.getElementById('alert-message');
            const alertText = document.getElementById('alert-text');
            
            if (alertMessage && alertText) {
                alertMessage.classList.remove('hidden', 'bg-yellow-100', 'border-yellow-400', 'text-yellow-700');
                alertMessage.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                alertText.textContent = 'Tidak ada data untuk dicetak. Silakan pilih filter terlebih dahulu.';
                
                setTimeout(() => {
                    alertMessage.classList.add('hidden');
                }, 5000);
            }
            return;
        }
        
        // Buat salinan tabel untuk dicetak
        const printContents = jawabanTable.outerHTML;
        
        // Buka jendela cetak baru
        const printWindow = window.open('', '_blank');
        
        // Tulis konten ke jendela cetak
        printWindow.document.write(`
            <html>
                <head>
                    <title>Cetak Data Jawaban</title>
                    <style>
                        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; }
                        h1 { text-align: center; color: #4a5568; margin-bottom: 30px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                        th, td { border: 1px solid #e2e8f0; padding: 12px; text-align: left; }
                        th { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600; }
                        tr:nth-child(even) { background-color: #f7fafc; }
                        .header-info { text-align: center; margin-bottom: 20px; color: #718096; }
                        @media print { body { margin: 0; } }
                    </style>
                </head>
                <body>
                    <h1><i class="fas fa-comments"></i> Daftar Jawaban Instrumen Kualitatif</h1>
                    <div class="header-info">
                        <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID')}</p>
                        <p>Total Data: ${jawabanTable.querySelector('tbody').rows.length}</p>
                    </div>
                    ${printContents}
                </body>
            </html>
        `);
        
        printWindow.document.close();
        
        // Tunggu hingga konten dimuat sebelum mencetak
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
    });
</script>

<!-- Fungsi untuk Export ke Excel -->
<script>
    function exportToExcel() {
        const table = document.getElementById('jawaban-table');
        
        // Cek apakah tabel ada dan memiliki data (tidak hidden)
        if (!table || table.classList.contains('hidden')) {
            // Tampilkan pesan error yang lebih baik
            const alertMessage = document.getElementById('alert-message');
            const alertText = document.getElementById('alert-text');
            
            if (alertMessage && alertText) {
                alertMessage.classList.remove('hidden', 'bg-yellow-100', 'border-yellow-400', 'text-yellow-700');
                alertMessage.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                alertText.textContent = 'Tidak ada data untuk diekspor. Silakan pilih filter terlebih dahulu.';
                
                setTimeout(() => {
                    alertMessage.classList.add('hidden');
                }, 5000);
            }
            return;
        }

        // Ambil elemen tabel
        const wb = XLSX.utils.table_to_book(table, { sheet: "Data Jawaban" });

        // Konversi workbook menjadi file Excel (XLSX)
        const excelBuffer = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });

        // Buat Blob dari buffer
        const blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

        // Buat URL untuk objek Blob
        const url = URL.createObjectURL(blob);

        // Buat elemen <a> untuk memicu unduhan
        const a = document.createElement('a');
        a.href = url;
        
        // Atur nama file
        const standar = table.querySelector('tbody tr td:nth-child(3)')?.textContent || 'Data';
        const fileName = `Data_Jawaban_${standar.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.xlsx`;
        a.download = fileName;

        // Klik link untuk memulai unduhan
        a.click();

        // Hapus URL objek setelah unduhan selesai
        URL.revokeObjectURL(url);
        
        // Tampilkan pesan sukses
        const alertMessage = document.getElementById('alert-message');
        const alertText = document.getElementById('alert-text');
        
        if (alertMessage && alertText) {
            alertMessage.classList.remove('hidden', 'bg-yellow-100', 'border-yellow-400', 'text-yellow-700', 'bg-red-100', 'border-red-400', 'text-red-700');
            alertMessage.classList.add('bg-green-100', 'border-green-400', 'text-green-700');
            alertText.textContent = 'Data berhasil diekspor ke Excel.';
            
            setTimeout(() => {
                alertMessage.classList.add('hidden');
            }, 5000);
        }
    }
</script>
@endpush