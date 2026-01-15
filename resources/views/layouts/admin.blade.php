<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>pharmacySys Admin - @yield('title', 'Dashboard')</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Buttons extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    <!-- Excel dependency -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .dataTables_wrapper select,
        .dataTables_wrapper input {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
        }

        /* Livewire Progress Bar Styling */
        .livewire-progress-bar {
            background: linear-gradient(to right, #3b82f6, #22d3ee) !important;
            height: 4px !important;
            box-shadow: 0 1px 10px rgba(59, 130, 246, 0.5);
        }

        /* Smooth Page Transitions */
        #main-content {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Ultra-Premium Radiant Pulse Loader */
        #nav-loader {
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #nav-loader.is-visible {
            opacity: 1;
            visibility: visible;
        }

        [x-cloak] { display: none !important; }

        /* Select2 Tailwind-like styling */
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            height: 42px !important;
            padding-top: 6px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
        .select2-dropdown {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        }

        /* Responsive DataTables */
        @media (max-width: 640px) {
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                margin-top: 0.5rem;
            }
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        /* Mobile-friendly scrollbars */
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }

        /* Better touch targets on mobile */
        @media (max-width: 640px) {
            button, a, input, select, textarea {
                min-height: 44px;
            }
        }
    </style>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-slate-50">
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, isNavigating: false }" 
         x-on:livewire:navigating.window="isNavigating = true"
         x-on:livewire:navigated.window="setTimeout(() => isNavigating = false, 300)"
         class="flex h-screen overflow-hidden">
        <!-- Specific Dots Navigation Loader -->
        <div id="nav-loader" 
             x-show="isNavigating" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-white/30 backdrop-blur-xl">
            <div class="relative flex flex-col items-center justify-center p-8 rounded-3xl bg-white/40 shadow-xl border border-white/40">
                <div class="flex justify-center items-center h-16">
                    <div class="flex gap-1">
                        <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
                <p class="text-indigo-900 font-medium tracking-wider text-xs uppercase mt-2">
                    Loading...
                </p>
            </div>
        </div>
        <!-- Mobile Backdrop Overlay -->
        <div x-show="sidebarOpen && window.innerWidth < 1024"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 lg:hidden"
             style="display: none;">
        </div>

        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @include('admin.partials.header')

            <!-- Main Content -->
            <main id="main-content" class="flex-1 overflow-y-auto bg-gray-50 p-3 sm:p-4 md:p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Page Content -->
                {{ $slot }}
            </main>

            <!-- Footer (Optional) -->
            <footer class="bg-white border-t px-4 py-3">
                <div class="text-center text-sm text-gray-600">
                    &copy; {{ date('Y') }} pharmacySys. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    @livewireScripts
</body>

</html>
