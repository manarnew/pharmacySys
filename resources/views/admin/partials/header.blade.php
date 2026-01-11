<header class="bg-white shadow-lg border-b border-gray-200/60 backdrop-blur-sm bg-white/95 sticky top-0 z-40">
    <div class="px-5 sm:px-7 lg:px-9">
        <div class="flex items-center justify-between h-18">
            <!-- Left side - Mobile menu button & Breadcrumb -->
            <div class="flex items-center">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2.5 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-200">
                    <span class="sr-only">Open sidebar</span>
                    <!-- Menu icon -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <!-- Breadcrumb / Page Title -->
                <div class="hidden lg:ml-5 lg:flex lg:items-center">
                    <div class="flex items-center text-sm font-medium">
                        <!-- Home/Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" 
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
                        @elseif(request()->routeIs('admin.patients.index'))
                        <span class="flex items-center text-gray-800">
                            <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mr-2.5">
                                <span class="text-blue-600">👥</span>
                            </div>
                            Patients
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
                <div class="lg:hidden ml-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        @if(request()->routeIs('admin.dashboard'))
                        <div class="h-9 w-9 rounded-xl bg-blue-50 flex items-center justify-center mr-3">
                            <span class="text-blue-600">📊</span>
                        </div>
                        Dashboard
                        @elseif(request()->routeIs('admin.patients.index'))
                        <div class="h-9 w-9 rounded-xl bg-blue-50 flex items-center justify-center mr-3">
                            <span class="text-blue-600">👥</span>
                        </div>
                        Patients
                        @else
                        <div class="h-9 w-9 rounded-xl bg-blue-50 flex items-center justify-center mr-3">
                            <span class="text-blue-600">👁️</span>
                        </div>
                        Optical Admin
                        @endif
                    </h2>
                </div>
            </div>

            <!-- Right side - Search & User Menu -->
            <div class="flex items-center space-x-5">
                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:block">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500 transition-colors" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search"
                            class="block w-72 pl-12 pr-4 py-2.5 border-2 border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all duration-200 shadow-sm hover:shadow"
                            placeholder="Search patients...">
                    </div>
                </div>

                <!-- Search Button (Mobile) -->
                <button class="lg:hidden p-2.5 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-200">
                    <span class="sr-only">Search</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="p-2.5 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-200 relative group">
                        <span class="sr-only">View notifications</span>
                        <!-- Bell icon -->
                        <svg class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <!-- Notification indicator -->
                        <span class="absolute top-2 right-2.5 block h-2.5 w-2.5 rounded-full bg-gradient-to-r from-red-500 to-red-400 shadow-lg shadow-red-400/50 border-2 border-white"></span>
                    </button>

                    <!-- Notifications dropdown -->
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl py-2 z-50 border border-gray-200/80">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900 flex items-center">
                                <span class="mr-2">🔔</span>
                                Notifications
                                <span class="ml-auto px-2.5 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded-full">3</span>
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">You have 3 unread notifications</p>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            <!-- Notification 1 -->
                            <a href="#" class="flex items-start px-5 py-4 hover:bg-gray-50/80 border-b border-gray-100/50 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center shadow-sm">
                                        <span class="text-blue-600 text-base">👁️</span>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">New patient registered</p>
                                    <p class="text-xs text-gray-500 mt-0.5">John Doe signed up 5 minutes ago</p>
                                </div>
                                <div class="ml-3">
                                    <span class="h-2 w-2 rounded-full bg-blue-500 inline-block animate-pulse"></span>
                                </div>
                            </a>

                            <!-- Notification 2 -->
                            <a href="#" class="flex items-start px-5 py-4 hover:bg-gray-50/80 border-b border-gray-100/50 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center shadow-sm">
                                        <span class="text-green-600 text-base">📅</span>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">Appointment reminder</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Sarah Smith at 2:00 PM today</p>
                                </div>
                                <div class="ml-3">
                                    <span class="text-xs text-gray-400">1h</span>
                                </div>
                            </a>

                            <!-- Notification 3 -->
                            <a href="#" class="flex items-start px-5 py-4 hover:bg-gray-50/80 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-50 flex items-center justify-center shadow-sm">
                                        <span class="text-yellow-600 text-base">📦</span>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">Low stock alert</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Contact lenses running low</p>
                                </div>
                                <div class="ml-3">
                                    <span class="text-xs text-gray-400">2h</span>
                                </div>
                            </a>
                        </div>
                        <div class="border-t border-gray-100">
                            <a href="#"
                                class="block px-5 py-3 text-sm font-medium text-blue-600 hover:bg-blue-50/50 text-center transition-colors rounded-b-2xl">
                                <span class="flex items-center justify-center">
                                    View all notifications
                                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

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
                        class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl py-2 z-50 border border-gray-200/80">
                        <!-- User info in dropdown (mobile) -->
                        <div class="lg:hidden px-5 py-4 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-base">A</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@optical.com' }}</p>
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
                        <form method="POST" action="">
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
        <div x-data="{ searchOpen: false }" class="lg:hidden">
            <div x-show="searchOpen" class="mt-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search"
                        class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl bg-white placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all duration-200"
                        placeholder="Search patients, appointments...">
                </div>
            </div>
        </div>
    </div>
</header>