<aside x-data="{ isCollapsed: false }" 
    x-show="sidebarOpen || window.innerWidth >= 1024"
    @click.away="if (window.innerWidth < 1024) sidebarOpen = false"
    class="bg-gradient-to-b from-gray-900 to-gray-950 border-r border-gray-800 w-64 flex flex-col h-screen fixed inset-y-0 left-0 transform lg:relative lg:translate-x-0 transition-all duration-300 ease-in-out z-[35] shadow-2xl"
    :class="{
        'translate-x-0': sidebarOpen || window.innerWidth >= 1024,
        '-translate-x-full': !sidebarOpen && window.innerWidth < 1024,
        'w-64': !isCollapsed,
        'w-20': isCollapsed && window.innerWidth >= 1024
    }">
    
    <!-- Header with Toggle -->
    <div class="px-4 py-5 flex-shrink-0 border-b border-gray-800 flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center space-x-3 group" :class="{ 'justify-center': isCollapsed }">
            @if($site_settings['logo'] ?? false)
                <div class="h-10 w-10 rounded-xl overflow-hidden flex items-center justify-center shadow-lg shadow-cyan-500/10 bg-white"
                     x-show="!isCollapsed">
                    <img src="{{ asset('storage/' . $site_settings['logo']) }}" alt="{{ $site_settings['site_name'] ?? 'Logo' }}" class="w-full h-full object-contain">
                </div>
                <div class="h-8 w-8 rounded-xl overflow-hidden flex items-center justify-center shadow-lg shadow-cyan-500/10 bg-white"
                     x-show="isCollapsed">
                    <img src="{{ asset('storage/' . $site_settings['logo']) }}" alt="{{ $site_settings['site_name'] ?? 'Logo' }}" class="w-full h-full object-contain">
                </div>
            @else
                <div class="h-10 w-10 rounded-xl overflow-hidden flex items-center justify-center shadow-lg shadow-cyan-500/10 bg-white"
                     x-show="!isCollapsed">
                    <span class="text-2xl">💊</span>
                </div>
                <div class="h-8 w-8 rounded-xl overflow-hidden flex items-center justify-center shadow-lg shadow-cyan-500/10 bg-white"
                     x-show="isCollapsed">
                    <span class="text-xl">💊</span>
                </div>
            @endif
            <div x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <h1 class="text-lg font-bold tracking-tight text-white leading-tight">
                   <span class="text-cyan-400">{{ $site_settings['site_name'] ?? 'pharmacySys EPS' }}</span>
                </h1>
                <p class="text-xs text-gray-400 font-medium">{{ __('Pharmacy Panel') }}</p>
            </div>
        </a>
        
        <!-- Collapse Toggle Button (Desktop only) -->
        <button @click="isCollapsed = !isCollapsed" 
                x-show="window.innerWidth >= 1024"
                class="hidden lg:flex items-center justify-center h-8 w-8 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white transition-colors duration-200">
            <svg x-show="!isCollapsed" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <svg x-show="isCollapsed" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    <!-- Mobile Toggle Button -->
    <button @click="sidebarOpen = false" 
            x-show="window.innerWidth < 1024 && sidebarOpen"
            class="lg:hidden absolute -right-3 top-6 h-6 w-6 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white transition-colors duration-200 z-40">
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Navigation (Scrollable) -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1 scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-transparent">
        <nav class="space-y-1">
            
            <!-- Dashboard -->
            @can('view_dashboard')
            <a href="{{ route('admin.dashboard') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.dashboard') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Dashboard') }}</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Customers -->
            @can('view_customer')
            <a href="{{ route('admin.customers.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.customers.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.customers.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M7 8a3 3 0 100-6 3 3 0 000 6zM14.5 9a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM1.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 017 18a9.953 9.953 0 01-5.385-1.572zM14.5 16h-.106c.07-.297.088-.611.048-.933a7.47 7.47 0 00-1.588-3.755 4.502 4.502 0 015.874 2.636.818.818 0 01-.36.98A7.465 7.465 0 0114.5 16z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Customers') }}</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.customers.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Users -->
            @can('view_user')
            <a href="{{ route('admin.users.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.users.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Users') }}</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Branches -->
            @can('view_branch')
            <a href="{{ route('admin.branches.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.branches.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.branches.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 10-2 0v2a1 1 0 01-1 1H6a1 1 0 010-2v-2a1 1 0 01-1-1V4zm3 1h6v4H7V5zm6 6H7v2h6v-2z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Branches') }}</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.branches.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Suppliers -->
            @can('view_supplier')
            <a href="{{ route('admin.suppliers.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.suppliers.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.suppliers.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                    <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Suppliers') }}</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.suppliers.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Permissions -->
            @can('view_permission')
            <a href="{{ route('admin.permissions.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.permissions.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.permissions.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v3H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-1V6a4 4 0 00-4-4zm2 7V6a2 2 0 00-2-2 2 2 0 00-2 2v3h4z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Permissions') }}</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.permissions.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Roles -->
            @can('view_role')
            <a href="{{ route('admin.roles.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.roles.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.roles.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Roles') }}</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.roles.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Expenses -->
            @can('view_expense')
            <a href="{{ route('admin.expenses.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.expenses.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.expenses.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Expenses') }}</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.expenses.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Products -->
            @can('view_product')
            <a href="{{ route('admin.products.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.products.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Products') }}</span>
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Stores -->
            @can('view_store')
            <a href="{{ route('admin.stores.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.stores.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.stores.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm7 5a1 1 0 10-2 0v1H8a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Stores') }}</span>
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.stores.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Purchases -->
            @can('view_purchase')
            <a href="{{ route('admin.purchases.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.purchases.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.purchases.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Purchases') }}</span>
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.purchases.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Sales -->
            @can('view_sale')
            <a href="{{ route('admin.sales.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.sales.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.sales.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Sales') }}</span>
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.sales.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Shifts -->
            <a href="{{ route('admin.shifts.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.shifts.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.shifts.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('shifts.shifts') }}</span>
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.shifts.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>

            <!-- Inventory -->
            <!-- Inventory -->
            @can('view_inventory')
            <div x-data="{ open: {{ request()->is('admin/inventory*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                    class="group flex w-full items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                    {{ request()->is('admin/inventory*') 
                        ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                        : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                    }}"
                    :class="{ 'justify-center': isCollapsed }">
                    <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                        {{ request()->is('admin/inventory*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                        :class="{ 'mr-3': !isCollapsed }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span x-show="!isCollapsed" class="flex-1 text-left text-sm font-medium">{{ __('Inventory') }}</span>
                    <svg x-show="!isCollapsed" class="ml-auto h-4 w-4 transform transition-transform duration-200" 
                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open && !isCollapsed" class="mt-1 space-y-1 pl-10" x-cloak>
                    <a href="{{ route('admin.inventory.index') }}" wire:navigate 
                       class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->routeIs('admin.inventory.index') ? 'text-white font-semibold' : '' }}">
                         {{ __('Current Stock') }}
                    </a>
                    @can('stocktake_view')
                    <a href="{{ route('admin.stocktakes.index') }}" wire:navigate 
                       class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->routeIs('admin.stocktakes.*') ? 'text-white font-semibold' : '' }}">
                         {{ __('Stocktakes') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan



            
            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.categories.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Categories') }}</span>
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>

            <!-- Settings -->
            <a href="{{ route('admin.settings.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.settings.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">{{ __('Settings') }}</span>
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
        </nav>
    </div>
</aside>