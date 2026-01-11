<aside x-data="{ sidebarOpen: window.innerWidth >= 1024 }" x-show="sidebarOpen || window.innerWidth >= 1024"
    @click.away="if (window.innerWidth < 1024) sidebarOpen = false"
    class="bg-gradient-to-b from-gray-900 to-gray-800 text-white w-64 flex flex-col h-screen fixed inset-y-0 left-0 transform lg:relative lg:translate-x-0 transition-all duration-300 ease-in-out z-30 shadow-xl"
    :class="{
        'translate-x-0': sidebarOpen || window.innerWidth >= 1024,
        '-translate-x-full': !sidebarOpen && window.innerWidth < 1024
    }">
    
    <!-- Logo (Fixed at top) -->
    <div class="px-6 py-6 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">👁️</span>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight">
                    <span class="bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">Optical</span>
                </h1>
                <p class="text-xs text-gray-400 mt-0.5">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation (Scrollable) -->
    <div class="flex-1 overflow-y-auto px-3 space-y-1 scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-transparent">
        <nav class="space-y-1 pb-4">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center py-3 px-3 rounded-xl transition-all duration-200 hover:bg-gray-700/50 hover:shadow-md hover:translate-x-1 border border-transparent hover:border-gray-600/30 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-900/40 to-blue-800/20 text-blue-300 border-blue-500/20 shadow-lg' : 'text-gray-300' }}">
                <div class="h-8 w-8 rounded-lg bg-gray-800 flex items-center justify-center mr-3 group-hover:bg-blue-900/30 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-900/40' : '' }}">
                    <span class="text-base">📊</span>
                </div>
                <span class="font-medium text-sm tracking-wide">Dashboard</span>
                @if(request()->routeIs('admin.dashboard'))
                    <div class="ml-auto h-2 w-2 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50"></div>
                @endif
            </a>

            <!-- Patients -->
            <a href="{{ route('admin.patients.index') }}"
                class="flex items-center py-3 px-3 rounded-xl transition-all duration-200 hover:bg-gray-700/50 hover:shadow-md hover:translate-x-1 border border-transparent hover:border-gray-600/30 {{ request()->routeIs('admin.patients.*') ? 'bg-gradient-to-r from-blue-900/40 to-blue-800/20 text-blue-300 border-blue-500/20 shadow-lg' : 'text-gray-300' }}">
                <div class="h-8 w-8 rounded-lg bg-gray-800 flex items-center justify-center mr-3 group-hover:bg-blue-900/30 {{ request()->routeIs('admin.patients.*') ? 'bg-blue-900/40' : '' }}">
                    <span class="text-base">👥</span>
                </div>
                <span class="font-medium text-sm tracking-wide">Patients</span>
                @if(request()->routeIs('admin.patients.*'))
                    <div class="ml-auto h-2 w-2 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50"></div>
                @endif
            </a>

            <!-- Users -->
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center py-3 px-3 rounded-xl transition-all duration-200 hover:bg-gray-700/50 hover:shadow-md hover:translate-x-1 border border-transparent hover:border-gray-600/30 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-900/40 to-blue-800/20 text-blue-300 border-blue-500/20 shadow-lg' : 'text-gray-300' }}">
                <div class="h-8 w-8 rounded-lg bg-gray-800 flex items-center justify-center mr-3 group-hover:bg-blue-900/30 {{ request()->routeIs('admin.users.*') ? 'bg-blue-900/40' : '' }}">
                    <span class="text-base">👤</span>
                </div>
                <span class="font-medium text-sm tracking-wide">Users</span>
                @if(request()->routeIs('admin.users.*'))
                    <div class="ml-auto h-2 w-2 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50"></div>
                @endif
            </a>

            <!-- Clinics -->
            <a href="{{ route('admin.clinics.index') }}"
                class="flex items-center py-3 px-3 rounded-xl transition-all duration-200 hover:bg-gray-700/50 hover:shadow-md hover:translate-x-1 border border-transparent hover:border-gray-600/30 {{ request()->routeIs('admin.clinics.*') ? 'bg-gradient-to-r from-blue-900/40 to-blue-800/20 text-blue-300 border-blue-500/20 shadow-lg' : 'text-gray-300' }}">
                <div class="h-8 w-8 rounded-lg bg-gray-800 flex items-center justify-center mr-3 group-hover:bg-blue-900/30 {{ request()->routeIs('admin.clinics.*') ? 'bg-blue-900/40' : '' }}">
                    <span class="text-base">🏢</span>
                </div>
                <span class="font-medium text-sm tracking-wide">Clinics</span>
                @if(request()->routeIs('admin.clinics.*'))
                    <div class="ml-auto h-2 w-2 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50"></div>
                @endif
            </a>

            <!-- Suppliers -->
            <a href="{{ route('admin.suppliers.index') }}"
                class="flex items-center py-3 px-3 rounded-xl transition-all duration-200 hover:bg-gray-700/50 hover:shadow-md hover:translate-x-1 border border-transparent hover:border-gray-600/30 {{ request()->routeIs('admin.suppliers.*') ? 'bg-gradient-to-r from-blue-900/40 to-blue-800/20 text-blue-300 border-blue-500/20 shadow-lg' : 'text-gray-300' }}">
                <div class="h-8 w-8 rounded-lg bg-gray-800 flex items-center justify-center mr-3 group-hover:bg-blue-900/30 {{ request()->routeIs('admin.suppliers.*') ? 'bg-blue-900/40' : '' }}">
                    <span class="text-base">📦</span>
                </div>
                <span class="font-medium text-sm tracking-wide">Suppliers</span>
                @if(request()->routeIs('admin.suppliers.*'))
                    <div class="ml-auto h-2 w-2 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50"></div>
                @endif
            </a>

            <!-- Permissions -->
            <a href="{{ route('admin.permissions.index') }}"
                class="flex items-center py-3 px-3 rounded-xl transition-all duration-200 hover:bg-gray-700/50 hover:shadow-md hover:translate-x-1 border border-transparent hover:border-gray-600/30 {{ request()->routeIs('admin.permissions.*') ? 'bg-gradient-to-r from-blue-900/40 to-blue-800/20 text-blue-300 border-blue-500/20 shadow-lg' : 'text-gray-300' }}">
                <div class="h-8 w-8 rounded-lg bg-gray-800 flex items-center justify-center mr-3 group-hover:bg-blue-900/30 {{ request()->routeIs('admin.permissions.*') ? 'bg-blue-900/40' : '' }}">
                    <span class="text-base">🔒</span>
                </div>
                <span class="font-medium text-sm tracking-wide">Permissions</span>
                @if(request()->routeIs('admin.permissions.*'))
                    <div class="ml-auto h-2 w-2 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50"></div>
                @endif
            </a>

            <!-- Expenses -->
            <a href="{{ route('admin.expenses.index') }}"
                class="flex items-center py-3 px-3 rounded-xl transition-all duration-200 hover:bg-gray-700/50 hover:shadow-md hover:translate-x-1 border border-transparent hover:border-gray-600/30 {{ request()->routeIs('admin.expenses.*') ? 'bg-gradient-to-r from-blue-900/40 to-blue-800/20 text-blue-300 border-blue-500/20 shadow-lg' : 'text-gray-300' }}">
                <div class="h-8 w-8 rounded-lg bg-gray-800 flex items-center justify-center mr-3 group-hover:bg-blue-900/30 {{ request()->routeIs('admin.expenses.*') ? 'bg-blue-900/40' : '' }}">
                    <span class="text-base">💰</span>
                </div>
                <span class="font-medium text-sm tracking-wide">Expenses</span>
                @if(request()->routeIs('admin.expenses.*'))
                    <div class="ml-auto h-2 w-2 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50"></div>
                @endif
            </a>
        
            <!-- Messages -->
            <a href="{{ route('admin.messages.index') }}"
                class="flex items-center py-3 px-3 rounded-xl transition-all duration-200 hover:bg-gray-700/50 hover:shadow-md hover:translate-x-1 border border-transparent hover:border-gray-600/30 {{ request()->routeIs('admin.messages.*') ? 'bg-gradient-to-r from-blue-900/40 to-blue-800/20 text-blue-300 border-blue-500/20 shadow-lg' : 'text-gray-300' }}">
                <div class="h-8 w-8 rounded-lg bg-gray-800 flex items-center justify-center mr-3 group-hover:bg-blue-900/30 {{ request()->routeIs('admin.messages.*') ? 'bg-blue-900/40' : '' }}">
                    <span class="text-base">💬</span>
                </div>
                <span class="font-medium text-sm tracking-wide">Messages</span>
                @if(request()->routeIs('admin.messages.*'))
                    <div class="ml-auto h-2 w-2 rounded-full bg-blue-400 shadow-lg shadow-blue-400/50"></div>
                @endif
            </a>
            
        </nav>
    </div>

 
</aside>