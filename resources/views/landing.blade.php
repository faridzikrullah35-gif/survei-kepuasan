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

    <style>
        .work-sans { font-family: 'Work Sans', sans-serif; }
        #menu-toggle:checked ~ #menu {
        display: block;
            }
        .hover\:grow { transition: all 0.3s; transform: scale(1); }
        .hover\:grow:hover { transform: scale(1.02); }
        .carousel-open:checked + .carousel-item { position: static; opacity: 100; }
        .carousel-item { -webkit-transition: opacity 0.6s ease-out; transition: opacity 0.6s ease-out; }
        #carousel-1:checked ~ .control-1, #carousel-2:checked ~ .control-2 { display: block; }
        .carousel-indicators { list-style: none; margin: 0; padding: 0; position: absolute; bottom: 2%; left: 0; right: 0; text-align: center; z-index: 10; }
        #carousel-1:checked ~ .control-1 ~ .carousel-indicators li:nth-child(1) .carousel-bullet,
        #carousel-2:checked ~ .control-2 ~ .carousel-indicators li:nth-child(2) .carousel-bullet { color: #000; }
        html {
            scroll-behavior: smooth;
        }
        section {
            scroll-margin-top: 100px;
        }
    </style>
</head>

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">

    <nav class="w-full border-b bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center px-6 py-5">

        <!-- LOGO -->
        <img src="assets/images/logo/logo (1).png" class="h-14">

        <!-- MENU DESKTOP -->
        <ul class="hidden md:flex space-x-8 text-lg font-medium">
            <li><a href="/" class="hover:text-black">Beranda</a></li>
            <li><a href="#survei" class="hover:text-black">Survei Kepuasan</a></li>
            <li><a href="#visi-misi-tujuan" class="hover:text-black">Visi, Misi & Tujuan</a></li>
        </ul>

        <!-- RIGHT SIDE -->
        <div class="flex items-center space-x-4">

            <!-- LOGIN DESKTOP -->
            <a href="{{ url('/login') }}"
            class="hidden md:block border border-gray-800 px-6 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 hover:text-white transition">
            Login
            </a>

            <!-- LOGIN MOBILE -->
            <a href="{{ url('/login') }}"
            class="block md:hidden border border-gray-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 hover:text-white transition">
            Login
            </a>

            <!-- HAMBURGER -->
            <button id="menu-btn" class="md:hidden text-2xl">
                ☰
            </button>

        </div>

    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="hidden md:hidden px-6 pb-4">
        <ul class="flex flex-col space-y-3 text-base">
            <li><a href="/" class="hover:text-black">Beranda</a></li>
            <li><a href="#survei" class="hover:text-black">Survei Kepuasan</a></li>
            <li><a href="#visi-misi-tujuan" class="hover:text-black">Visi, Misi & Tujuan</a></li>
        </ul>
    </div>
</nav>

<!-- MAPS -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6">

        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-blue-500 inline-block">
            Lokasi Kampus
        </h2>

        <div class="w-full h-[400px] rounded-lg overflow-hidden shadow">
            <iframe 
                src="https://www.google.com/maps?q=-3.2484752,114.6287748&z=17&output=embed"
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>

    </div>
</section>

<div id="beranda" class="carousel relative w-full overflow-hidden">

<!-- SURVEI -->
<section id="survei" class="bg-white py-16 border-b">
    <div class="container mx-auto px-6 text-center max-w-4xl">

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
            Survei Kepuasan Lembaga Penjaminan Mutu - LPM
        </h1>

        <p class="text-lg text-gray-600 leading-relaxed">
            Website ini digunakan sebagai sarana untuk mengukur tingkat kepuasan sivitas akademika 
            terhadap layanan yang diberikan oleh Lembaga Penjaminan Mutu Universitas Muhammadiyah Banjarmasin. 
            Melalui survei ini, diharapkan diperoleh masukan yang objektif guna meningkatkan kualitas layanan 
            akademik maupun non-akademik secara berkelanjutan.
        </p>

    </div>
</section>

    <div class="carousel relative w-full overflow-hidden">

        <div id="slides" class="flex transition-transform duration-700 ease-in-out">

            <!-- SLIDE 1 -->
            <div class="min-w-full flex items-center justify-center bg-no-repeat bg-center bg-contain bg-gray-100"
                style="height:600px; background-image:url('https://lpm.umbjm.ac.id/img/Informasi/1770638083.jpeg');">
            </div>

            <!-- SLIDE 2 -->
            <div class="min-w-full flex items-center justify-center bg-no-repeat bg-center bg-contain bg-gray-100"
                style="height:600px; background-image:url('https://lpm.umbjm.ac.id/img/Informasi/1771587363.jpeg');">
            </div>

            <!-- SLIDE 3 -->
            <div class="min-w-full flex items-center justify-center bg-no-repeat bg-center bg-contain bg-gray-100"
                style="height:600px; background-image:url('https://lpm.umbjm.ac.id/img/Informasi/1770638122.jpeg');">
            </div>

        </div>

        <!-- BUTTON -->
        <button id="prevBtn"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-4 py-2 rounded-full shadow">
            ‹
        </button>

        <button id="nextBtn"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white px-4 py-2 rounded-full shadow">
            ›
        </button>

    </div>

    <!-- VISI MISI -->
    <section id="visi-misi-tujuan" class="bg-gray-50 py-12">
        <div class="container py-8 px-6 mx-auto">
            <h2 class="uppercase tracking-wide font-bold text-gray-800 text-2xl mb-8 border-b-2 border-blue-500 inline-block">
                Visi, Misi & Tujuan
            </h2>
            
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h3 class="font-bold text-xl text-black-900 mb-4 px-4 py-2 border border-blue-500 inline-block rounded">
                        Visi
                    </h3>
                    <p class="text-gray-700 italic leading-relaxed border-l-4 border-blue-500 pl-4 mt-2">
                        "Menjadi <span class="font-semibold">center of excellence</span> dalam pengembangan dan implementasi Sistem Penjaminan Mutu Internal (SPMI) untuk menjamin peningkatan kualitas (SPME) output UM Banjarmasin yang terkemuka, unggul, professional, dan berkarakter Islam yang berkemajuan".
                    </p>
                </div>

                <div>
                    <h3 class="font-bold text-xl text-black-900 mb-4 px-4 py-2 border border-blue-500 inline-block rounded">
                        Misi
                    </h3>
                    <ul class="list-none space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <span class="font-bold mr-2 text-black-600">A.</span>
                            <span>Mengembangkan sistem manajemen dan budaya mutu untuk mewujudkan <span class="italic">good university governance</span>.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2 text-black-600">B.</span>
                            <span>Mengembangkan penjaminan mutu akademik berbasis sistem informasi untuk peningkatan daya saing nasional menuju internasional.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2 text-black-600">C.</span>
                            <span>Meningkatkan reputasi UM Banjarmasin di tingkat regional, nasional dan internasional.</span>
                        </li>
                    </ul>
                </div>

                <div class="md:col-span-2">
                    <h3 class="font-bold text-xl text-black-900 mb-4 px-4 py-2 border border-blue-500 inline-block rounded">
                        Tujuan
                    </h3>
                    
                    <div class="mb-8 p-6 bg-blue-50 rounded-lg border-l-4 border-blue-500 text-gray-700">
                        <p class="font-bold mb-2">Kebijakan Sistem Penjaminan Mutu Internal (SPMI) UM Banjarmasin:</p>
                        <p class="text-sm leading-relaxed">
                            Komitmen penerapan SPMI yang efektif dengan mengacu pada standar mutu berbasis risiko untuk peningkatan daya saing regional dan nasional menuju internasional untuk menciptakan budaya dan peningkatan mutu berkelanjutan melalui siklus <span class="font-bold">PPEPP</span> (Penetapan, Pelaksanaan, Evaluasi, Pengendalian, Peningkatan).
                        </p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow-sm border-t-4 border-blue-400 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Tujuan 1</span>
                                <p class="text-gray-700 mt-2 text-sm">Terwujudnya <span class="italic font-medium">good university governance</span> dan budaya mutu melalui implementasi sistem manajemen mutu di tingkat universitas, UPPS dan PS, serta Lembaga, biro dan unit lainnya.</p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 italic text-xs text-gray-500">
                                <span class="font-bold block text-gray-600 mb-1">Sasaran:</span>
                                SS-LPM-01, SS-LPM-02
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm border-t-4 border-blue-400 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Tujuan 2</span>
                                <p class="text-gray-700 mt-2 text-sm">Tersedianya sistem informasi penjaminan mutu akademik untuk pencapaian akreditasi unggul dan akreditasi internasional.</p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 italic text-xs text-gray-500">
                                <span class="font-bold block text-gray-600 mb-1">Sasaran:</span>
                                SS-LPM-03, SS-LPM-04
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm border-t-4 border-blue-400 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Peningkatan Reputasi & Akuntabilitas</span>
                                <p class="text-gray-700 mt-2 text-sm italic">Fokus pada peningkatan reputasi nasional/internasional, mutu non-akademik, serta akuntabilitas keuangan perguruan tinggi.</p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 italic text-xs text-gray-500">
                                <span class="font-bold block text-gray-600 mb-1">Sasaran:</span>
                                SS-LPM-05, SS-LPM-06, SS-LPM-07
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    // ======================
    // CAROUSEL JS VERSION
    // ======================

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

    // AUTO SLIDE
    function startAuto() {
        autoSlide = setInterval(nextSlide, 5000);
    }

    function stopAuto() {
        clearInterval(autoSlide);
    }

    startAuto();

    // BUTTON
    document.getElementById('nextBtn').addEventListener('click', () => {
        nextSlide();
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        prevSlide();
    });

    // HOVER PAUSE
    const carousel = document.querySelector('.carousel');

    carousel.addEventListener('mouseenter', stopAuto);
    carousel.addEventListener('mouseleave', startAuto);
</script>

</body>

</html>