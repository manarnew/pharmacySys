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
        @if($this->notifications->count() > 0)
        <span class="absolute top-2 right-2.5 block h-2.5 w-2.5 rounded-full bg-gradient-to-r from-red-500 to-red-400 shadow-lg shadow-red-400/50 border-2 border-white"></span>
        @endif
    </button>

    <!-- Notifications dropdown -->
    <div x-show="open" @click.away="open = false" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-3 w-[calc(100vw-2rem)] sm:w-96 max-w-sm bg-white rounded-2xl shadow-2xl py-2 z-50 border border-gray-200/80"
         style="display: none;">
        
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900 flex items-center">
                <span class="mr-2">🔔</span>
                Notifications
                @if($this->notifications->count() > 0)
                <span class="ml-auto px-2.5 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded-full">{{ $this->notifications->count() }}</span>
                @endif
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                @if($this->notifications->count() > 0)
                    You have {{ $this->notifications->count() }} alerts
                @else
                    No new notifications
                @endif
            </p>
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse($this->notifications as $notification)
            <a href="{{ $notification['route'] }}" class="flex items-start px-5 py-4 hover:bg-gray-50/80 border-b border-gray-100/50 transition-colors">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-{{ $notification['color'] }}-100 to-{{ $notification['color'] }}-50 flex items-center justify-center shadow-sm">
                        <span class="text-{{ $notification['color'] }}-600 text-base">{{ $notification['icon'] }}</span>
                    </div>
                </div>
                <div class="ml-4 flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900">{{ $notification['title'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $notification['message'] }}</p>
                </div>
                <div class="ml-3">
                    @if($notification['type'] === 'expired')
                        <span class="h-2 w-2 rounded-full bg-red-500 inline-block animate-ping"></span>
                    @endif
                </div>
            </a>
            @empty
            <div class="px-5 py-8 text-center text-gray-500">
                <div class="mb-2">🎉</div>
                <p class="text-sm">All caught up! No alerts.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
