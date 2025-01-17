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
            .dropdown-content {
                position: absolute;
                bottom: 100%; /* Munculkan di atas */
                right: 0;     /* Align ke kanan */
                transform: translateY(-10px); /* Geser sedikit ke atas */
                transition: transform 0.2s ease, opacity 0.2s ease;
                opacity: 0;  /* Tersembunyi secara default */
                visibility: hidden;
            }

            .dropdown-content.show {
                opacity: 1;   /* Tampilkan dropdown */
                visibility: visible;
                transform: translateY(0); /* Geser ke posisi semula */
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
                },
                openSidebar: JSON.parse(localStorage.getItem('sidebar')) ?? true,
                toggleSidebar() {
                    this.openSidebar = !this.openSidebar;
                    localStorage.setItem('sidebar', JSON.stringify(this.openSidebar));
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
                            <a href="{{ route('dashboard') }}" active="{{ request()->routeIs('dashboard') }}" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M9 21V9h6v12" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Dashboard</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Dashboard
                            </div>
                        </li>
                        
                        <!-- Permissions Menu Item -->
                        @can('view permissions')
                        <li class="relative group">
                            <a href="{{ route('permissions.index') }}" active="{{ request()->routeIs('permissions.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11V7a4 4 0 10-8 0v4m8 0h4a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2h4z" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Permissions</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" 
                            class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Permissions
                            </div>
                        </li>
                        @endcan
            
                        <!-- Roles Menu Item -->
                        @can('view roles')
                        <li class="relative group">
                            <a href="{{ route('roles.index') }}" active="{{ request()->routeIs('roles.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.98 2.5l.02 2.563a8.022 8.022 0 00-1.713.775l-1.771-1.77-2.8 2.8 1.769 1.77a8.034 8.034 0 00-.776 1.714H2.5v3h2.563a8.022 8.022 0 00.775 1.713l-1.77 1.771 2.8 2.8 1.77-1.769a8.034 8.034 0 001.714.776V21.5h3v-2.563a8.022 8.022 0 001.713-.775l1.771 1.77 2.8-2.8-1.769-1.77a8.034 8.034 0 00.776-1.714H21.5v-3h-2.563a8.022 8.022 0 00-.775-1.713l1.77-1.771-2.8-2.8-1.77 1.769a8.034 8.034 0 00-1.714-.776V2.5h-3zM12 15a3 3 0 110-6 3 3 0 010 6z" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Roles</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Roles
                            </div>
                        </li>
                        @endcan

                        @can('view articles')
                        <li class="relative group">
                            <a href="{{ route('articles.index') }}" active="{{ request()->routeIs('articles.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Articles</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Articles
                            </div>
                        </li>
                        @endcan
                        
                        @can('view users')
                        <li class="relative group">
                            <a href="{{ route('users.index') }}" active="{{ request()->routeIs('users.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700" x-data @mouseover.prefetch>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 11a4 4 0 100-8 4 4 0 000 8zm5 8h.01M7 16a4 4 0 014-4h6a4 4 0 014 4" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">Users</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                Users
                            </div>
                        </li>
                        @endcan

                        <!-- Profile Menu Item -->
                        <li class="relative group">
                            <a href="{{ route('profile.edit') }}" class="flex items-center p-2 rounded hover:bg-gray-700" x-data>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c3.866 0 7-3.134 7-7S15.866 0 12 0 5 3.134 5 7s3.134 7 7 7zm0 0c4.418 0 8 2.015 8 4.5v1.5H4v-1.5C4 16.015 7.582 14 12 14z" />
                                </svg>
                                <span x-show="open" class="ml-3 transition-all duration-300">{{ __('Profile') }}</span>
                            </a>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                {{ __('Profile') }}
                            </div>
                        </li>

                        <!-- Logout Menu Item -->
                        <li class="relative group">
                            <form method="POST" action="{{ route('logout') }}" class="flex items-center p-2 rounded hover:bg-gray-700" x-data>
                                @csrf
                                <button type="submit" class="flex items-center w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H5a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v1" />
                                    </svg>
                                    <span x-show="open" class="ml-3 transition-all duration-300">{{ __('Log Out') }}</span>
                                </button>
                            </form>
                            <!-- Tooltip -->
                            <div x-show="!open" class="absolute left-16 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white text-sm px-2 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-transition.opacity>
                                {{ __('Log Out') }}
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
