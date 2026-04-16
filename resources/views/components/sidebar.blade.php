<!-- resources/views/components/sidebar.blade.php -->
<!-- 
  - `fixed lg:relative`: Posisi tetap di HP, normal di desktop.
  - `-translate-x-full lg:translate-x-0`: Sembunyikan di HP, tampilkan di desktop.
  - `transition-transform`: Animasi halus.
  - `z-30`: Agar berada di atas konten saat terbuka di HP.
-->
<aside id="sidebar-wrapper" 
       class="w-64 bg-slate-800 text-white h-screen fixed lg:relative sidebar-transition 
              -translate-x-full lg:translate-x-0">

    <div class="p-4">
        <!-- Logo/Brand -->
        <a href="{{ route('dashboard') }}" class="text-xl font-bold block">
            SURVEI KEPUASAN
        </a>
    </div>
    
    <nav class="px-4 pb-4">
        <ul class="space-y-2">
            <!-- Pertanyaan Kuantitatif -->
            <li x-data="{ open: {{ request()->is('pertanyaan*') || request()->is('tahun_akademik*') || request()->is('survei*') || request()->is('instrumen*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-slate-700 {{ request()->is('pertanyaan*') || request()->is('tahun_akademik*') || request()->is('survei*') || request()->is('instrumen*') ? 'bg-slate-700' : '' }}">
                    <span class="flex items-center">
                        <i class="fas fa-question-circle mr-3"></i>
                        <span>Survei Kuantitatif</span>
                    </span>
                    <svg class="w-4 h-4" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul x-show="open" x-transition class="mt-2 space-y-1 pl-8" style="display: none;">
                    @if (auth()->user()->role === 'admin')
                        <li><a href="{{ route('pertanyaan.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('pertanyaan.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Tambah Survei Baru</a></li>
                        <li><a href="{{ route('tahun_akademik.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('tahun_akademik.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Tahun Akademik</a></li>
                        <li><a href="{{ route('survei.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('survei.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Survei</a></li>
                    @endif
                    <li><a href="{{ route('instrumen.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('instrumen.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Instrumen</a></li>
                </ul>
            </li>

            <!-- Pertanyaan Kualitatif -->
            <li x-data="{ open: {{ request()->is('pertanyaan-teks*') || request()->is('tahunAkademik-teks*') || request()->is('survei-teks*') || request()->is('instrumen_teks*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-slate-700 {{ request()->is('pertanyaan-teks*') || request()->is('tahunAkademik-teks*') || request()->is('survei-teks*') || request()->is('instrumen_teks*') ? 'bg-slate-700' : '' }}">
                    <span class="flex items-center">
                        <i class="fas fa-question-circle mr-3"></i>
                        <span>Survei Kualitatif</span>
                    </span>
                    <svg class="w-4 h-4" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul x-show="open" x-transition class="mt-2 space-y-1 pl-8" style="display: none;">
                    @if (auth()->user()->role === 'admin')
                        <li><a href="{{ route('pertanyaan-teks.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('pertanyaan-teks.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Tambah Survei Baru</a></li>
                        <li><a href="{{ route('tahunAkademik-teks.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('tahunAkademik-teks.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Tahun Akademik</a></li>
                        <li><a href="{{ route('survei-teks.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('survei-teks.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Survei</a></li>
                    @endif
                    <li><a href="{{ route('instrumen_teks.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('instrumen_teks.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Instrumen</a></li>
                </ul>
            </li>

            @if (auth()->user()->role === 'admin')
                <!-- Diagram Nilai -->
                <li x-data="{ open: {{ request()->is('chart*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-slate-700 {{ request()->is('chart*') ? 'bg-slate-700' : '' }}">
                        <span class="flex items-center">
                            <i class="fas fa-chart-pie mr-3"></i>
                            <span>Diagram Nilai</span>
                        </span>
                        <svg class="w-4 h-4" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul x-show="open" x-transition class="mt-2 space-y-1 pl-8" style="display: none;">
                        <li><a href="{{ route('chart.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('chart.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Diagram Data Nilai</a></li>
                    </ul>
                </li>

                <!-- Jawaban Instrumen Kualitatif -->
                <li x-data="{ open: {{ request()->is('jawaban*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-slate-700 {{ request()->is('jawaban*') ? 'bg-slate-700' : '' }}">
                        <span class="flex items-center">
                            <i class="fas fa-database mr-3"></i>
                            <span>Jawaban Kualitatif</span>
                        </span>
                        <svg class="w-4 h-4" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul x-show="open" x-transition class="mt-2 space-y-1 pl-8" style="display: none;">
                        <li><a href="{{ route('jawaban.index') }}" class="block py-1 px-2 text-sm rounded hover:bg-slate-600 {{ request()->routeIs('jawaban.index') ? 'text-white font-semibold' : 'text-gray-300' }}">Data Jawaban</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
</aside>

<!-- Overlay untuk menutup sidebar saat dibuka di HP -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden hidden"></div>