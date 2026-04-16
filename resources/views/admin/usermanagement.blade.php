@extends('layouts.app')

@section('title', 'Users Management')

@section('main')
<div class="main-content p-4 md:p-6 lg:p-8 bg-gray-50 min-h-screen">
    <section class="section">
        <!-- Header -->
        <div class="section-header mb-6">
            <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
            <div class="section-header-breadcrumb text-sm text-gray-600 mt-2">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                <span class="mx-2">/</span>
                <span class="text-white">User Management</span>
            </div>
        </div>

        <div class="section-body">
            <!-- Card untuk membungkus konten -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="section-title text-xl font-semibold !text-gray-900 mb-4">Daftar Semua Pengguna</h2>

                <!-- Pesan Sukses dan Error -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    {{-- Script untuk auto-hide menggunakan Alpine.js (jika Anda menggunakannya) atau JS biasa --}}
                    <script>
                        setTimeout(() => {
                            const alert = document.querySelector('.alert');
                            if(alert) alert.style.display = 'none';
                        }, 5000);
                    </script>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                     <script>
                        setTimeout(() => {
                            const alert = document.querySelector('.alert');
                            if(alert) alert.style.display = 'none';
                        }, 5000);
                    </script>
                @endif

                <!-- Tombol Aksi -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Tambah User Baru
                    </a>
                    <a href="{{ route('showForm') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        <i class="fas fa-file-excel mr-2"></i> Import dari Excel
                    </a>
                    <a href="{{ route('role-index.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white font-medium text-sm rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                        <i class="fas fa-user-tag mr-2"></i> Tambah Role
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white font-medium text-sm rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>

                <!-- Tabel Data -->
                <div class="overflow-x-auto shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($data as $i => $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                        {{ $data->firstItem() + $i }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->role)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucwords(preg_replace('/([a-z])([A-Z])/', '$1 $2', $user->role)) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                        <a href="{{ route('users.show', $user->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Tidak ada data pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($data->hasPages())
                    <div class="mt-6">
                        {{ $data->links('pagination::tailwind') }}
                    </div>
                @endif

                <!-- Footer -->
                <p class="text-center text-gray-500 text-xs mt-6">
                    Daftar Pengguna - Sistem Survei Kepuasan
                </p>
            </div>
        </div>
    </section>
</div>
@endsection
