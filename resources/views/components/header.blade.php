<!-- resources/views/components/header.blade.php -->
<header class="bg-white shadow-sm border-b border-gray-200 relative z-30 fixed top-0 left-0 right-0">
    <div class="flex items-center justify-between px-4 py-3">

    <!-- LEFT AREA -->
    <div class="w-10 flex items-center">
        @auth
            @if(auth()->user()->role === 'admin')
                <button id="sidebar-toggle"
                    class="text-gray-600 hover:text-gray-900 focus:outline-none p-1 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <svg id="hamburger-icon" class="w-6 h-6 transition-transform duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            @endif
        @endauth
    </div>

        <!-- RIGHT AREA (PROFILE) -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 focus:outline-none">
                <img 
                    alt="image" 
                    src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('img/avatar/avatar-1.png') }}" 
                    class="w-8 h-8 rounded-full">
                <div class="hidden sm:block">
                    <div class="text-sm font-medium">Hi, {{ auth()->user()->name }}</div>
                </div>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div 
                x-show="open" 
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5"
                style="display: none;">
                
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="far fa-user mr-2"></i> Profile Setting
                </a>

                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('usermanagement') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i> User Management
                        </a>
                    @endif
                @endauth
                
                <div class="border-t border-gray-100"></div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>