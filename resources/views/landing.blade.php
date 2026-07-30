<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LPM - Universitas Muhammadiyah Banjarmasin</title>
    <meta name="description" content="Lembaga Penjaminan Mutu UM Banjarmasin">

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .work-sans { font-family: 'Work Sans', sans-serif; }
        #menu-toggle:checked ~ #menu { display: block; }
        .hover\:grow { transition: all 0.3s; transform: scale(1); }
        .hover\:grow:hover { transform: scale(1.02); }
        .carousel-open:checked + .carousel-item { position: static; opacity: 100; }
        .carousel-item { -webkit-transition: opacity 0.6s ease-out; transition: opacity 0.6s ease-out; }
        #carousel-1:checked ~ .control-1, #carousel-2:checked ~ .control-2 { display: block; }
        .carousel-indicators { list-style: none; margin: 0; padding: 0; position: absolute; bottom: 2%; left: 0; right: 0; text-align: center; z-index: 10; }
        #carousel-1:checked ~ .control-1 ~ .carousel-indicators li:nth-child(1) .carousel-bullet,
        #carousel-2:checked ~ .control-2 ~ .carousel-indicators li:nth-child(2) .carousel-bullet { color: #000; }
        html { scroll-behavior: smooth; }
        section { scroll-margin-top: 100px; }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-card-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stat-card-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">

    <nav class="w-full border-b bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-5">
            <img src="assets/images/logo/logo (1).png" class="h-14">
            <ul class="hidden md:flex space-x-8 text-lg font-medium">
                <li><a href="/" class="hover:text-black">Beranda</a></li>
                <li><a href="#chart-data" class="hover:text-black">Data Survei</a></li>
            </ul>
            <div class="flex items-center space-x-4">
                <a href="{{ url('/login') }}" class="hidden md:block border border-gray-800 px-6 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 hover:text-white transition">Login</a>
                <a href="{{ url('/login') }}" class="block md:hidden border border-gray-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 hover:text-white transition">Login</a>
                <button id="menu-btn" class="md:hidden text-2xl">☰</button>
            </div>
            <div id="mobile-menu" class="hidden md:hidden px-6 pb-4">
                <ul class="flex flex-col space-y-3 text-base">
                    <li><a href="/" class="hover:text-black">Beranda</a></li>
                    <li><a href="#chart-data" class="hover:text-black">Data Survei</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- SURVEI -->
    <section id="survei" class="bg-white py-16 border-b">
        <div class="container mx-auto px-6 text-center max-w-4xl">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">UNIVERSITAS MUHAMMADIYAH BANJARMASIN</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Website ini digunakan sebagai sarana untuk mengukur tingkat kepuasan sivitas akademika
                terhadap layanan yang diberikan oleh Universitas Muhammadiyah Banjarmasin.
                Melalui survei ini, diharapkan diperoleh masukan yang objektif guna meningkatkan kualitas layanan
                akademik maupun non-akademik secara berkelanjutan.
            </p>
        </div>
    </section>

    <!-- CAROUSEL -->
    <div class="carousel relative w-full overflow-hidden">
        <div id="slides" class="flex transition-transform duration-700 ease-in-out">
            @forelse($slides as $slide)
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
                <div class="min-w-full flex items-center justify-center bg-no-repeat bg-center bg-contain bg-gray-100"
                    style="height:600px; @if($base64) background-image:url('{{ $base64 }}'); @endif">
                </div>
            @empty
                <div class="min-w-full flex flex-col items-center justify-center bg-gray-200" style="height:600px;">
                    <svg class="w-20 h-20 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada slide. Silakan tambahkan melalui admin.</p>
                </div>
            @endforelse
        </div>
        <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-4 py-2 rounded-full shadow">‹</button>
        <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white px-4 py-2 rounded-full shadow">›</button>
    </div>

    <!-- ========================================================== -->
    <!-- SECTION FILTER + CHART + STATISTIK (ID chart-data) -->
    <!-- ========================================================== -->
    <section id="chart-data" class="bg-gray-50 py-12">
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
                            <form method="GET" action="{{ route('landing') }}#chart-data">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div class="form-group">
                                        <label for="tahun_akademik_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-calendar-alt mr-1 text-blue-500"></i>
                                            Pilih Tahun Akademik
                                        </label>
                                        <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                            <option value="">Semua Tahun Akademik</option>
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
                                            <option value="">Semua Standar Survei</option>
                                            @foreach($instrumenUntukDropdown as $item)
                                                <option value="{{ $item->id }}" {{ request('instrumen_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->standar }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-users mr-1 text-blue-500"></i>
                                            Pilih Role/Pengguna
                                        </label>
                                        <select name="role" id="role" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                                            <option value="">Semua Role/Pengguna</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $role)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center">
                                        <i class="fas fa-chart-pie mr-2"></i>
                                        Tampilkan Diagram Survei
                                    </button>
                                    <a href="{{ route('landing') }}#chart-data" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 flex items-center">
                                        <i class="fas fa-redo mr-2"></i>
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================================== -->
            <!-- CHART SECTION – hanya tampil jika filter dipilih -->
            <!-- ========================================================== -->
            @php
                $showChart = request()->filled('tahun_akademik_id')
                    || request()->filled('instrumen_id')
                    || request()->filled('role');
            @endphp
            @if($showChart)
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
                            <!-- Container chart -->
                            <div id="chartContainer"
                                class="chart-container"
                                style="position: relative; height: 350px; width: 100%; max-width: 500px; margin: 0 auto;">
                                <canvas id="nilaiChartLanding"></canvas>
                            </div>

                            <!-- Ringkasan nilai -->
                            <div class="grid grid-cols-4 gap-4 mt-6 text-center" id="nilaiSummary">
                                <div class="p-3 bg-red-100 rounded-lg">
                                    <span class="block text-2xl font-bold text-red-600">
                                        {{ $nilaiCounts->nilai_1 ?? 0 }}
                                    </span>
                                    <span class="text-xs text-gray-600">Nilai 1</span>
                                </div>

                                <div class="p-3 bg-yellow-100 rounded-lg">
                                    <span class="block text-2xl font-bold text-yellow-600">
                                        {{ $nilaiCounts->nilai_2 ?? 0 }}
                                    </span>
                                    <span class="text-xs text-gray-600">Nilai 2</span>
                                </div>

                                <div class="p-3 bg-green-100 rounded-lg">
                                    <span class="block text-2xl font-bold text-green-600">
                                        {{ $nilaiCounts->nilai_3 ?? 0 }}
                                    </span>
                                    <span class="text-xs text-gray-600">Nilai 3</span>
                                </div>

                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <span class="block text-2xl font-bold text-blue-600">
                                        {{ $nilaiCounts->nilai_4 ?? 0 }}
                                    </span>
                                    <span class="text-xs text-gray-600">Nilai 4</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistics Section -->
            <div class="flex justify-center">
                <div class="w-full lg:w-4/5 xl:w-3/4">
                    <div class="card bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-600 to-cyan-700 px-6 py-4 shadow-md"
                            style="background: linear-gradient(135deg, #0d9488, #0e7490);">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                Statistik Pengguna
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @php
                                    $icons = [
                                        'mahasiswa' => 'fas fa-user-graduate',
                                        'dosen' => 'fas fa-chalkboard-teacher',
                                        'tenaga_kependidikan' => 'fas fa-user-tie',
                                        'alumni' => 'fas fa-user-check',
                                        'dinas' => 'fas fa-building',
                                        'masyarakat' => 'fas fa-users',
                                    ];
                                    $cardClass = ['', 'stat-card-2', 'stat-card-3'];
                                @endphp

                                @foreach($roleCounts as $index => $role)
                                    <div class="stat-card {{ $cardClass[$index % 3] }} rounded-lg p-6 text-center">
                                        <i class="{{ $icons[$role->role] ?? 'fas fa-user' }} text-4xl mb-3"></i>
                                        <h3 class="text-lg font-semibold mb-1">
                                            {{ ucwords(str_replace('_', ' ', $role->role)) }}
                                        </h3>
                                        <p class="text-3xl font-bold">{{ $role->total }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="container mx-auto bg-white py-8 border-t border-gray-400">
        <div class="flex flex-wrap px-6">
            <div class="w-full lg:w-1/2">
                <h3 class="font-bold text-gray-900">Alamat</h3>
                <p class="py-4 text-sm">
                    Kampus Utama Lantai 2
                    Jl. Gubernur Sarkawi, Semangat Dalam, Kec. Alalak, Kabupaten Barito Kuala, Kalimantan Selatan 70581<br>
                    No. Telepon: - <br>
                    mail: lpm@umbjm.ac.id
                </p>
            </div>
            <div class="w-full lg:w-1/2 lg:text-right mt-6 md:mt-0">
                <h3 class="font-bold text-gray-900">Media Sosial</h3>
                <div class="flex lg:justify-end py-4">
                    <a href="#" class="mx-2 hover:text-blue-500 text-gray-600">IG</a>
                    <a href="#" class="mx-2 hover:text-blue-700 text-gray-600">FB</a>
                    <a href="#" class="mx-2 hover:text-blue-400 text-gray-600">TW</a>
                </div>
            </div>
        </div>
        <div class="text-center py-6 border-t border-gray-100 mt-8">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Lembaga Penjaminan Mutu - UMBJM. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        // MOBILE MENU
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // CAROUSEL
        const slidesContainer = document.getElementById('slides');
        const totalSlides = slidesContainer.children.length;
        let index = 0;
        let autoSlide;

        function updateSlide() {
            slidesContainer.style.transform = `translateX(-${index * 100}%)`;
        }

        function nextSlide() {
            index = (index + 1) % totalSlides;
            updateSlide();
        }

        function prevSlide() {
            index = (index - 1 + totalSlides) % totalSlides;
            updateSlide();
        }

        function startAuto() {
            autoSlide = setInterval(nextSlide, 5000);
        }

        function stopAuto() {
            clearInterval(autoSlide);
        }

        startAuto();

        document.getElementById('nextBtn').addEventListener('click', () => {
            nextSlide();
        });
        document.getElementById('prevBtn').addEventListener('click', () => {
            prevSlide();
        });

        const carousel = document.querySelector('.carousel');
        carousel.addEventListener('mouseenter', stopAuto);
        carousel.addEventListener('mouseleave', startAuto);

        // ======================================================
        // SCROLL OTOMATIS KE SECTION FILTER SETELAH LOAD
        // ======================================================
        window.addEventListener('load', function() {
            if (window.location.search.length > 0 || window.location.hash === '#chart-data') {
                const target = document.getElementById('chart-data');
                if (target) {
                    setTimeout(() => {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 300);
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil canvas
            var canvas = document.getElementById('nilaiChartLanding');
            if (!canvas) {
                console.warn('Canvas tidak ditemukan!');
                return;
            }

            // Data dari server (pastikan variabel ini ada)
            var dataNilai = {
                nilai1: {{ $nilaiCounts->nilai_1 ?? 0 }},
                nilai2: {{ $nilaiCounts->nilai_2 ?? 0 }},
                nilai3: {{ $nilaiCounts->nilai_3 ?? 0 }},
                nilai4: {{ $nilaiCounts->nilai_4 ?? 0 }}
            };

            var total = dataNilai.nilai1 + dataNilai.nilai2 + dataNilai.nilai3 + dataNilai.nilai4;

            // Jika total > 0, buat chart; jika tidak, tampilkan pesan
            if (total > 0) {
                var ctx = canvas.getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Nilai 1', 'Nilai 2', 'Nilai 3', 'Nilai 4'],
                        datasets: [{
                            label: 'Jumlah Jawaban',
                            data: [dataNilai.nilai1, dataNilai.nilai2, dataNilai.nilai3, dataNilai.nilai4],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(54, 162, 235, 0.7)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            } else {
                // Tampilkan pesan di container chart
                var container = document.getElementById('chartContainer');
                if (container) {
                    container.innerHTML = '<p class="text-center text-gray-500 mt-12">Belum ada data survei untuk ditampilkan.</p>';
                }
            }
        });
    </script>

</body>
</html>