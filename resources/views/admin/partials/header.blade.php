<header class="bg-white shadow-lg border-b border-gray-200/60 backdrop-blur-sm bg-white/95 sticky top-0 z-40">
    <div class="px-5 sm:px-7 lg:px-9">
        <div class="flex items-center justify-between h-18">
            <!-- Left side - Mobile menu button & Breadcrumb -->
            <div class="flex items-center">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2.5 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-200 z-50 relative">
                    <span class="sr-only">Toggle sidebar</span>
                    <!-- Menu icon (hamburger) -->
                    <svg x-show="!sidebarOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close icon (X) -->
                    <svg x-show="sidebarOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Breadcrumb / Page Title -->
                <div class="hidden lg:ml-5 lg:flex lg:items-center">
                    <div class="flex items-center text-sm font-medium">
                        <!-- Home/Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" wire:navigate
                           class="text-gray-500 hover:text-blue-600 transition-colors duration-200 flex items-center">
                            <div class="h-8 w-8 rounded-lg bg-blue-50 flex items-center justify-center mr-2.5">
                                <span class="text-blue-500">🏠</span>
                            </div>
                            Dashboard
                        </a>

                        <!-- Separator -->
                        <svg class="flex-shrink-0 mx-3 h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>

                        <!-- Current Page -->
                        @if(request()->routeIs('admin.dashboard'))
                        <span class="flex items-center text-gray-800">
                            <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mr-2.5">
                                <span class="text-blue-600">📈</span>
                            </div>
                            Overview
                        </span>
                        @elseif(request()->routeIs('admin.customers.index'))
                        <span class="flex items-center text-gray-800">
                            <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mr-2.5">
                                <span class="text-blue-600">👥</span>
                            </div>
                            Customers
                        </span>
                        @else
                        <span class="text-gray-800 flex items-center">
                            <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mr-2.5">
                                <span class="text-blue-600">📋</span>
                            </div>
                            {{ ucfirst(str_replace('.', ' ', Route::currentRouteName())) }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Mobile Page Title -->
                <div class="lg:hidden ml-2 sm:ml-4">
                    <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 flex items-center">
                        @if(request()->routeIs('admin.dashboard'))
                        <div class="h-8 w-8 sm:h-9 sm:w-9 rounded-xl bg-blue-50 flex items-center justify-center mr-2 sm:mr-3">
                            <span class="text-blue-600">📊</span>
                        </div>
                        Dashboard
                        @elseif(request()->routeIs('admin.customers.index'))
                        <div class="h-8 w-8 sm:h-9 sm:w-9 rounded-xl bg-blue-50 flex items-center justify-center mr-2 sm:mr-3">
                            <span class="text-blue-600">👥</span>
                        </div>
                        Customers
                        @else
                        <div class="h-8 w-8 sm:h-9 sm:w-9 rounded-xl bg-blue-50 flex items-center justify-center mr-2 sm:mr-3">
                            <span class="text-blue-600">👁️</span>
                        </div>
                        pharmacySys EPS Admin
                        @endif
                    </h2>
                </div>
            </div>

            <!-- Right side - Search & User Menu -->
            <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-5">
                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:block w-72">
                    @livewire('admin.global-search')
                </div>

                <!-- Search Button (Mobile) -->
                <button @click="$dispatch('toggle-search')" class="lg:hidden p-2.5 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-200">
                    <span class="sr-only">Search</span>
                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Notifications -->
                @livewire('admin.partials.header-notifications')

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-3.5 p-2.5 rounded-xl hover:bg-gray-100/80 transition-all duration-200 group">
                        <!-- Avatar -->
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                            <span class="text-white font-bold text-base">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </span>
                        </div>

                        <!-- User info (desktop only) -->
                        <div class="hidden lg:block text-left">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</p>
                        </div>

                        <!-- Dropdown icon -->
                        <svg class="h-4 w-4 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-3 w-[calc(100vw-2rem)] sm:w-56 max-w-xs bg-white rounded-2xl shadow-2xl py-2 z-50 border border-gray-200/80">
                        <!-- User info in dropdown (mobile) -->
                        <div class="lg:hidden px-5 py-4 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-base">A</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@pharmacy.com' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu items -->
                        <a href="#" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50/80 transition-colors">
                            <div class="h-8 w-8 rounded-lg bg-blue-50 flex items-center justify-center mr-3">
                                <span class="text-blue-500">👤</span>
                            </div>
                            My Profile
                        </a>

                        <a href="#" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50/80 transition-colors">
                            <div class="h-8 w-8 rounded-lg bg-purple-50 flex items-center justify-center mr-3">
                                <span class="text-purple-500">⚙️</span>
                            </div>
                            Settings
                        </a>

                        <a href="#" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50/80 transition-colors">
                            <div class="h-8 w-8 rounded-lg bg-green-50 flex items-center justify-center mr-3">
                                <span class="text-green-500">🆘</span>
                            </div>
                            Help & Support
                        </a>

                        <div class="border-t border-gray-100 my-2"></div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full text-left px-5 py-3 text-sm text-red-600 hover:bg-red-50/80 transition-colors rounded-b-2xl">
                                <div class="h-8 w-8 rounded-lg bg-red-50 flex items-center justify-center mr-3">
                                    <span class="text-red-500">🚪</span>
                                </div>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar (Mobile Expanded) -->
        <div x-data="{ searchOpen: false }" @toggle-search.window="searchOpen = !searchOpen" class="lg:hidden">
            <div x-show="searchOpen" x-transition class="mt-3 px-2">
                @livewire('admin.global-search')
            </div>
        </div>

    </div>
</header>