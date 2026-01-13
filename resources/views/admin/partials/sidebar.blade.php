<aside x-data="{ sidebarOpen: window.innerWidth >= 1024, isCollapsed: false }" 
    x-show="sidebarOpen || window.innerWidth >= 1024"
    @click.away="if (window.innerWidth < 1024) sidebarOpen = false"
    class="bg-gradient-to-b from-gray-900 to-gray-950 border-r border-gray-800 w-64 flex flex-col h-screen fixed inset-y-0 left-0 transform lg:relative lg:translate-x-0 transition-all duration-300 ease-in-out z-30 shadow-2xl"
    :class="{
        'translate-x-0': sidebarOpen || window.innerWidth >= 1024,
        '-translate-x-full': !sidebarOpen && window.innerWidth < 1024,
        'w-64': !isCollapsed,
        'w-20': isCollapsed && window.innerWidth >= 1024
    }">
    
    <!-- Header with Toggle -->
    <div class="px-4 py-5 flex-shrink-0 border-b border-gray-800 flex items-center justify-between">
        <div class="flex items-center space-x-3" :class="{ 'justify-center': isCollapsed }">
            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/10">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <div x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <h1 class="text-lg font-bold tracking-tight text-white">
                    Optical
                </h1>
                <p class="text-xs text-gray-400 font-medium">Admin Panel</p>
            </div>
        </div>
        
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
            x-show="window.innerWidth < 1024"
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
                      class="text-sm font-medium">Dashboard</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Patients -->
            @can('view_patient')
            <a href="{{ route('admin.patients.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.patients.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.patients.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M7 8a3 3 0 100-6 3 3 0 000 6zM14.5 9a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM1.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 017 18a9.953 9.953 0 01-5.385-1.572zM14.5 16h-.106c.07-.297.088-.611.048-.933a7.47 7.47 0 00-1.588-3.755 4.502 4.502 0 015.874 2.636.818.818 0 01-.36.98A7.465 7.465 0 0114.5 16z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">Patients</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.patients.*') ? 'true' : 'false' }}"
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
                      class="text-sm font-medium">Users</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Clinics -->
            @can('view_clinic')
            <a href="{{ route('admin.clinics.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.clinics.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.clinics.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 10-2 0v2a1 1 0 01-1 1H6a1 1 0 010-2v-2a1 1 0 01-1-1V4zm3 1h6v4H7V5zm6 6H7v2h6v-2z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">Clinics</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.clinics.*') ? 'true' : 'false' }}"
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
                      class="text-sm font-medium">Suppliers</span>
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
                      class="text-sm font-medium">Permissions</span>
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
                      class="text-sm font-medium">Roles</span>
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
                      class="text-sm font-medium">Expenses</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.expenses.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan
        
            <!-- Orders -->
            @can('view_order')
            <a href="{{ route('admin.orders.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.orders.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">Orders</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.orders.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            @endcan

            <!-- Messages -->
            <a href="{{ route('admin.messages.index') }}" wire:navigate
                class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 relative
                {{ request()->routeIs('admin.messages.*') 
                    ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg shadow-cyan-500/10' 
                    : 'text-gray-400 hover:bg-gray-800/60 hover:text-white' 
                }}"
                :class="{ 'justify-center': isCollapsed }">
                <svg class="h-5 w-5 flex-shrink-0 transition-colors duration-200
                    {{ request()->routeIs('admin.messages.*') ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }}"
                    :class="{ 'mr-3': !isCollapsed }"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                </svg>
                <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200" 
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium">Messages</span>
                <!-- Active indicator dot - only shows when collapsed AND active -->
                <template x-if="isCollapsed">
                    <div x-show="{{ request()->routeIs('admin.messages.*') ? 'true' : 'false' }}"
                         class="absolute left-14 w-2 h-2 rounded-full bg-cyan-400"></div>
                </template>
            </a>
            
        </nav>
    </div>
</aside>