<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] {
                display: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900"
            x-data="{
                open: JSON.parse(localStorage.getItem('sidebar')) ?? true,
                transitioning: false,
                initialized: true,
                toggle() {
                    this.transitioning = true; // Mulai transisi
                    setTimeout(() => {
                        this.open = !this.open;
                        this.transitioning = false; // Selesai transisi
                        localStorage.setItem('sidebar', JSON.stringify(this.open)); // Simpan status
                    }, 300); // Durasi transisi sidebar
                }
            }"
            x-persist
            x-cloak
        >
            <!-- Sidebar -->
            <aside :class="open ? 'w-64' : 'w-16'" class="transition-all duration-300 bg-gray-800 text-white flex flex-col">
                <!-- Burger Button -->
                <div class="p-4 flex items-center justify-between">
                    <h1 x-show="open" class="text-xl font-bold transition-all duration-300" x-transition.opacity>
                        CMS Syncz
                    </h1>
                    <button @click="toggle" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            
                <!-- Sidebar Menu -->
                <nav class="flex-1 space-y-2 px-2 relative">
                    <ul>
                        <!-- Dashboard Menu Item -->
                        <li class="relative group">
                            <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3M16 5l5 5-5 5" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Dashboard</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Dashboard
                            </div>
                        </li>
            
                        <!-- Permissions Menu Item -->
                        <li class="relative group">
                            <a href="/permissions" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6-6m0 0l6 6m-6-6v18" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Permissions</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" 
                            class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Permissions
                            </div>
                        </li>
            
                        <!-- Roles Menu Item -->
                        <li class="relative group">
                            <a href="/roles" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Roles</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Roles
                            </div>
                        </li>
                        <li class="relative group">
                            <a href="/articles" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Articles</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Articles
                            </div>
                        </li>
                        <li class="relative group">
                            <a href="/users" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4.992 4.992 0 005 16c0-1.657 1.343-3 3-3s3 1.343 3 3a4.992 4.992 0 00-.121.804m5.302 0A4.992 4.992 0 0015 16c0-1.657 1.343-3 3-3s3 1.343 3 3a4.992 4.992 0 00-.121.804M9 21H7a2 2 0 01-2-2v-1a4 4 0 014-4h6a4 4 0 014 4v1a2 2 0 01-2 2h-2M15 21v-3a3 3 0 00-6 0v3" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Users</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Users
                            </div>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
        {{-- <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div> --}}
    </body>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    @isset($script)
        {{ $script }}
    @endisset
</html>
