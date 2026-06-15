@extends('layouts.app')

@section('title', 'Edit Role')

@section('main')

<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header Halaman -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Role</h1>

        <nav class="flex mt-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">

                <li class="inline-flex items-center">
                    <a href="{{ route('usermanagement') }}"
                       class="text-gray-700 hover:text-indigo-600 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2.5"
                             fill="currentColor"
                             viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd"
                                  d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100 4h2a1 1 0 100 2 2 2 0 01-2 2H4a2 2 0 01-2-2V7a2 2 0 012-2z"
                                  clip-rule="evenodd">
                            </path>
                        </svg>
                        Manajemen Pengguna
                    </a>
                </li>

                <li class="inline-flex items-center">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400"
                             fill="currentColor"
                             viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd">
                            </path>
                        </svg>

                        <a href="{{ route('role-index.index') }}"
                           class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">
                            Role
                        </a>
                    </div>
                </li>

                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400"
                             fill="currentColor"
                             viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd">
                            </path>
                        </svg>

                        <span class="ml-1 text-gray-500 md:ml-2">
                            Edit
                        </span>
                    </div>
                </li>

            </ol>
        </nav>
    </div>

    <!-- Tombol Kembali -->
    <a href="{{ route('role-index.index') }}"
       class="mb-6 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

        <svg class="mr-2 -ml-1 w-5 h-5"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 19l-7-7m0 0l7-7m-7 7h18">
            </path>
        </svg>

        Kembali ke Daftar Role
    </a>

    <!-- Card -->
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">
                Formulir Edit Role
            </h2>

            <p class="text-sm text-gray-600">
                Perbarui nama role yang dipilih.
            </p>
        </div>

        <div class="p-6">

            @if (count($errors) > 0)
                <div class="mb-6 p-4 rounded-md bg-red-50 border-l-4 border-red-400">
                    <div class="flex">

                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                      clip-rule="evenodd">
                                </path>
                            </svg>
                        </div>

                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Ada {{ $errors->count() }} kesalahan yang ditemukan
                            </h3>

                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('role.update', $role->id) }}"
                  class="space-y-6">

                @csrf
                @method('PUT')

                <div>
                    <label for="name"
                           class="block text-sm font-medium text-gray-700">
                        Nama Role
                    </label>

                    <div class="mt-1">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $role->name) }}"
                            placeholder="Contoh: Alumni"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <p class="mt-2 text-sm text-gray-500">
                        Gunakan nama role yang jelas dan mudah dipahami.
                    </p>
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">

                        <svg class="mr-2 -ml-1 w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7">
                            </path>
                        </svg>

                        Update Role
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

</div>
@endsection
