@extends('layouts.app')

@section('title', 'Chart Data')

@push('style')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom styles for better appearance */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .btn {
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        @media (max-width: 768px) {
            .chart-container {
                height: 300px;
            }
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stat-card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .breadcrumb-item a {
            position: relative;
            transition: color 0.3s ease;
        }
        .breadcrumb-item a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        .breadcrumb-item a:hover::after {
            width: 100%;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .table-container {
            overflow-x: auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .table th {
            background-color: #f9fafb;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #4b5563;
        }
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        .table tbody tr:hover {
            background-color: #f9fafb;
        }
        .alert {
            border-radius: 0.5rem;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content p-4 md:p-6 lg:p-8">
        <!-- Header Section -->
        <section class="mb-8">
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Data Nilai Instrumen Survei</h1>
                <div class="w-24 h-1 bg-blue-500 mx-auto mb-6"></div>
                <div class="breadcrumb flex justify-center text-sm">
                    <div class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                    </div>
                    <div class="mx-2 text-gray-500">/</div>
                    <div class="breadcrumb-item">
                        <a href="{{ route('instrumen.index') }}" class="text-blue-600 hover:text-blue-800">Instrumen Kuantitatif</a>
                    </div>
                    <div class="mx-2 text-gray-500">/</div>
                    <div class="breadcrumb-item">
                        <span class="text-gray-600">Data Diagram</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mx-auto px-4">
            <!-- Filter Form Card -->
            <div class="flex justify-center mb-8">
                <div class="w-full lg:w-4/5 xl:w-3/4">
                    <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-filter mr-2"></i>
                                Filter Data Survei
                            </h2>
                        </div>
                        <div class="p-6">
                            <form method="GET" action="{{ route('chart.index') }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div class="form-group">
                                        <label for="tahun_akademik_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-calendar-alt mr-1 text-blue-500"></i>
                                            Pilih Tahun Akademik
                                        </label>
                                        <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                            <option value="">Semua Tahun Akademik</option> {{-- default untuk semua --}}
                                            @foreach($tahunAkademik as $tahun)
                                                <option value="{{ $tahun->id }}" {{ request('tahun_akademik_id') == $tahun->id ? 'selected' : '' }}>
                                                    {{ $tahun->tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="instrumen_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-list-alt mr-1 text-blue-500"></i>
                                            Pilih Standar Survei
                                        </label>
                                        <select name="instrumen_id" id="instrumen_id" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                            <option value="">Semua Standar Survei</option> {{-- default untuk semua --}}
                                            @foreach($instrumenUntukDropdown as $item)
                                                <option value="{{ $item['id'] }}" {{ request('instrumen_id') == $item['id'] ? 'selected' : '' }}>
                                                    {{ $item['standar'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-users mr-1 text-blue-500"></i>
                                            Pilih Role/Pengguna
                                        </label>
                                        <select name="role" id="role"
                                            class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                            <option value="">Semua Role/Pengguna</option>
                                            <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>
                                                Mahasiswa
                                            </option>
                                            <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>
                                                Dosen
                                            </option>
                                            <option value="tenaga_kependidikan" {{ request('role') == 'tenaga_kependidikan' ? 'selected' : '' }}>
                                                Tenaga Kependidikan
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <button id="loadChartBtn" type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg 
                                            hover:bg-blue-600 hover:text-white
                                            focus:outline-none focus:ring-2 focus:ring-blue-500 
                                            flex items-center">
                                        <i class="fas fa-chart-pie mr-2"></i>
                                        Tampilkan Diagram Survei
                                    </button>

                                    <button type="button"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg 
                                            hover:bg-green-600 hover:text-white
                                            focus:outline-none focus:ring-2 focus:ring-green-500 
                                            flex items-center"
                                        onclick="printChart()">
                                        <i class="fas fa-print mr-2"></i>
                                        Cetak Diagram
                                    </button>
                                    <a href="{{ route('chart.export', request()->query()) }}"
                                        class="px-6 py-2 !bg-purple-600 !text-white rounded-lg
                                                hover:!bg-purple-600 hover:!text-white">
                                        Export Excel
                                    </a>
                                    <a href="{{ route('chart.index') }}"
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg
                                            hover:bg-red-600 hover:text-white
                                            focus:outline-none focus:ring-2 focus:ring-red-500
                                            flex items-center">
                                        <i class="fas fa-redo mr-2"></i>
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Message -->
            <div id="alert-message" class="alert p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg mb-6 hidden">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span id="alert-text"></span>
                </div>
            </div>

            <!-- Chart Section -->
            @if(request('instrumen_id') && $data->isNotEmpty())
                <div class="flex justify-center mb-8">
                    <div class="w-full lg:w-4/5 xl:w-3/4">
                        <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                                <h2 class="text-xl font-semibold text-white flex items-center">
                                    <i class="fas fa-chart-pie mr-2"></i>
                                    Hasil Survei
                                </h2>
                            </div>
                            <div class="p-6">
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                                    <p class="text-sm">
                                        Jumlah jawaban untuk instrumen survei kuantitatif,
                                        @if($data->isNotEmpty())
                                            <strong>{{ $data->first()->standar }}:</strong>
                                        @endif
                                    </p>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                        <div class="text-center p-3 bg-white rounded-lg shadow">
                                            <div class="text-2xl font-bold text-red-500">{{ $nilaiCounts->nilai_1 ?? 0 }}</div>
                                            <div class="text-xs text-gray-600">Nilai 1 - Sangat Kurang</div>
                                        </div>
                                        <div class="text-center p-3 bg-white rounded-lg shadow">
                                            <div class="text-2xl font-bold text-yellow-500">{{ $nilaiCounts->nilai_2 ?? 0 }}</div>
                                            <div class="text-xs text-gray-600">Nilai 2 - Kurang</div>
                                        </div>
                                        <div class="text-center p-3 bg-white rounded-lg shadow">
                                            <div class="text-2xl font-bold text-green-500">{{ $nilaiCounts->nilai_3 ?? 0 }}</div>
                                            <div class="text-xs text-gray-600">Nilai 3 - Baik</div>
                                        </div>
                                        <div class="text-center p-3 bg-white rounded-lg shadow">
                                            <div class="text-2xl font-bold text-blue-500">{{ $nilaiCounts->nilai_4 ?? 0 }}</div>
                                            <div class="text-xs text-gray-600">Nilai 4 - Sangat Baik</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="chartToPrint" class="chart-container flex justify-center">
                                    <canvas id="nilaiChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @if(request('instrumen_id'))
                    <div class="flex justify-center mb-8">
                        <div class="w-full lg:w-4/5 xl:w-3/4">
                            <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                                <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                                    <h2 class="text-xl font-semibold text-white flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Informasi
                                    </h2>
                                </div>
                                <div class="p-6">
                                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                        <p class="text-sm">Silakan pilih standar dari dropdown untuk melihat hasil.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Data Table Section -->
            <div class="flex justify-center mb-8">
                <div class="w-full lg:w-4/5 xl:w-3/4">
                    <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-table mr-2"></i>
                                Tabel Data Survei
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="table-container">
                                <table id="dataToPrint" class="w-full table-auto hidden">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 text-left">No</th>
                                            <th class="px-4 py-3 text-left">Tahun Akademik</th>
                                            <th class="px-4 py-3 text-left">Standar</th>
                                            <th class="px-4 py-3 text-left">Pertanyaan</th>
                                            <th class="px-4 py-3 text-left">Nilai</th>
                                            <th class="px-4 py-3 text-left">Kritik & Saran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data as $index => $item)
                                            <tr class="border-b">
                                                <td class="px-4 py-3">{{ $loop->iteration + ($data->currentPage()-1)*$data->perPage() }}</td>
                                                <td class="px-4 py-3">{{ $item->tahun_akademik }}</td>
                                                <td class="px-4 py-3">{{ $item->standar }}</td>
                                                <td class="px-4 py-3">{{ $item->pertanyaan }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                        @if($item->nilai == 1) bg-red-100 text-red-800
                                                        @elseif($item->nilai == 2) bg-yellow-100 text-yellow-800
                                                        @elseif($item->nilai == 3) bg-green-100 text-green-800
                                                        @else bg-blue-100 text-blue-800
                                                        @endif">
                                                        {{ $item->nilai }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">{{ $item->kritik_saran ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Silakan pilih filter terlebih dahulu.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:justify-between">
                                    
                                    <div class="text-sm text-gray-600">
                                        Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} 
                                        dari {{ $data->total() }} data
                                    </div>

                                    <div class="overflow-x-auto">
                                        {{ $data->withQueryString()->links() }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="flex justify-center">
                <div class="w-full lg:w-4/5 xl:w-3/4">
                    <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                Statistik Pengguna
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="stat-card rounded-lg p-6 text-center">
                                    <i class="fas fa-user-graduate text-4xl mb-3"></i>
                                    <h3 class="text-lg font-semibold mb-1">Mahasiswa</h3>
                                    <p class="text-3xl font-bold">{{ $totalMahasiswa }}</p>
                                </div>
                                <div class="stat-card stat-card-2 rounded-lg p-6 text-center">
                                    <i class="fas fa-chalkboard-teacher text-4xl mb-3"></i>
                                    <h3 class="text-lg font-semibold mb-1">Dosen</h3>
                                    <p class="text-3xl font-bold">{{ $totalDosen }}</p>
                                </div>
                                <div class="stat-card stat-card-3 rounded-lg p-6 text-center">
                                    <i class="fas fa-user-tie text-4xl mb-3"></i>
                                    <h3 class="text-lg font-semibold mb-1">Tenaga Kependidikan</h3>
                                    <p class="text-3xl font-bold">{{ $totalTenagaKependidikan }}</p>
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

<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===============================
       CHART.JS
    =============================== */

    const chartCanvas = document.getElementById('nilaiChart');

    if (chartCanvas) {

        const data = {
            labels: ['Nilai 1','Nilai 2','Nilai 3','Nilai 4'],
            datasets: [{
                label: 'Jumlah Nilai',
                data: [
                    {{ $nilaiCounts->nilai_1 ?? 0 }},
                    {{ $nilaiCounts->nilai_2 ?? 0 }},
                    {{ $nilaiCounts->nilai_3 ?? 0 }},
                    {{ $nilaiCounts->nilai_4 ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(255,99,132,0.7)',
                    'rgba(240,255,29,0.7)',
                    'rgba(29,250,0,0.7)',
                    'rgba(75,192,192,0.7)'
                ],
                borderWidth:2
            }]
        };

        new Chart(chartCanvas,{
            type:'pie',
            data:data,
            options:{
                responsive:true,
                maintainAspectRatio:false
            }
        });

    }

    /* ===============================
       DROPDOWN DINAMIS
    =============================== */

    const tahunSelect = document.getElementById('tahun_akademik_id');
    const instrumenSelect = document.getElementById('instrumen_id');

    if (tahunSelect && instrumenSelect) {

        tahunSelect.addEventListener('change', async function(){

            const tahunId = this.value;

            try {

                if(!tahunId){
                    instrumenSelect.innerHTML =
                        '<option value="">Semua Standar Survei</option>';
                    return;
                }

                const response = await fetch(
                    `{{ route('chart.getInstrumen') }}?tahun_akademik_id=${tahunId}`
                );

                const data = await response.json();

                if(!data || data.length === 0){
                    console.warn("Instrumen kosong untuk tahun ini");
                    return; // jangan reset dropdown
                }

                instrumenSelect.innerHTML =
                    '<option value="">Semua Standar Survei</option>';

                data.forEach(item => {

                    const option = document.createElement('option');

                    option.value = item.id;
                    option.textContent = item.standar;

                    instrumenSelect.appendChild(option);

                });

            } catch(err) {

                console.error('Fetch error:',err);

                instrumenSelect.innerHTML =
                    '<option value="">Semua Standar Survei</option>';

            }

        });

    }

    /* ===============================
       TABLE DATA CHECK
    =============================== */

    const chartTable = document.getElementById('dataToPrint');
    const alertMessage = document.getElementById('alert-message');
    const alertText = document.getElementById('alert-text');

    if(chartTable){

        const rows = chartTable.querySelector('tbody')?.rows.length ?? 0;

        if(rows > 0){

            chartTable.classList.remove('hidden');

            if(alertMessage)
                alertMessage.classList.add('hidden');

        }else{

            chartTable.classList.add('hidden');

            if(alertMessage){
                alertMessage.classList.remove('hidden');
                alertText.textContent = 'Tidak ada data untuk ditampilkan.';
            }

        }

    }

});


/* ===============================
   PRINT CHART
================================ */

function printChart(){

    const table = document.getElementById('dataToPrint');
    const chart = document.getElementById('nilaiChart');

    if(!table && !chart){
        alert('Data tidak ditemukan.');
        return;
    }

    const printWindow = window.open('','','height=600,width=800');

    let tableContent = '';
    let chartImage = '';

    if(table){
        tableContent = table.querySelector('tbody')?.innerHTML ?? '';
    }

    if(chart){
        chartImage = chart.toDataURL('image/png');
    }

    printWindow.document.write(`
        <html>
        <head>
        <title>Cetak Data</title>
        <style>
        table{width:100%;border-collapse:collapse}
        th,td{border:1px solid #ddd;padding:8px}
        </style>
        </head>
        <body>

        <h3>Data Nilai Instrumen Mahasiswa</h3>

        <table>
        <thead>
        <tr>
        <th>No</th>
        <th>Tahun Akademik</th>
        <th>Standar</th>
        <th>Pertanyaan</th>
        <th>Nilai</th>
        </tr>
        </thead>
        <tbody>${tableContent}</tbody>
        </table>

        ${chartImage ? `<h3>Chart</h3><img src="${chartImage}" />` : ''}

        </body>
        </html>
    `);

    printWindow.document.close();

    setTimeout(()=>{
        printWindow.print();
    },800);

}


/* ===============================
   EXPORT EXCEL
================================ */

function exportToExcel(){

    const table = document.getElementById('dataToPrint');

    if(!table || table.classList.contains('hidden')){
        alert('Tidak ada data untuk diekspor.');
        return;
    }

    const wb = XLSX.utils.table_to_book(table,{sheet:"Data Survei"});

    const excelBuffer =
        XLSX.write(wb,{bookType:'xlsx',type:'array'});

    const blob = new Blob(
        [excelBuffer],
        {type:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'}
    );

    const url = URL.createObjectURL(blob);

    const a = document.createElement('a');

    const standar =
        table.querySelector('tbody tr td:nth-child(3)')?.textContent
        ?? 'Data';

    a.href = url;

    a.download =
        `Data_${standar.replace(/\s+/g,'_')}_${new Date().toISOString().slice(0,10)}.xlsx`;

    a.click();

    URL.revokeObjectURL(url);

}

</script>

@endpush