<!-- resources/views/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title') &mdash; Survei Kepuasan</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    
    <!-- Vite (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('style')
</head>

<body class="bg-gray-100">
    <div id="app" class="flex h-screen overflow-hidden">
        
        <!-- WRAPPER untuk Sidebar dan Konten -->
        <div id="main-layout" class="flex flex-1 overflow-hidden sidebar-visible">
            
            <!-- Sidebar -->
            @auth
                @if(auth()->user()->role === 'admin')
                    @include('components.sidebar')
                @endif
            @endauth

            <!-- Wrapper untuk Header, Konten, dan Footer -->
            <div class="flex flex-col flex-1 overflow-hidden">
                <!-- Header (yang sekarang berisi tombol) -->
                @include('components.header')

                <!-- Konten Utama -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 lg:p-6">
                    @yield('main')
                </main>

                <!-- Footer -->
                @include('components.footer')
            </div>
        </div>
    </div>

    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>    

    <!-- Script untuk Toggle Sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar-wrapper');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const mainLayout = document.getElementById('main-layout');

        // Fungsi untuk mengecek ukuran layar
        function isMobile() {
            return window.innerWidth < 1024; // lg: breakpoint
        }

        function toggleSidebar() {
            if (isMobile()) {
                // --- LOGIKA MOBILE ---
                // Hanya toggle class translate dan overlay
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('translate-x-0');
                sidebarOverlay.classList.toggle('hidden');
            } else {
                // --- LOGIKA DESKTOP ---
                // Hanya toggle class di main-layout untuk mengatur lebar
                mainLayout.classList.toggle('sidebar-visible');
                mainLayout.classList.toggle('sidebar-hidden');
            }

            // Animasi ikon berlaku untuk keduanya
            if (hamburgerIcon) {
                hamburgerIcon.classList.toggle('rotate-90');
            }
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarOverlay) {
            // Overlay hanya ada di mobile, jadi kita gunakan logika mobile
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                sidebarOverlay.classList.add('hidden');
                if (hamburgerIcon) {
                    hamburgerIcon.classList.remove('rotate-90');
                }
            });
        }
    });
</script>
    @stack('scripts')
    
</body>
</html>