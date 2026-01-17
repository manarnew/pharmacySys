<div x-data="{ startDate: '{{ $startDate }}', endDate: '{{ $endDate }}' }">
    <!-- Header with Date Filter -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 sm:mb-6 gap-4">
        <h2 class="font-semibold text-lg sm:text-xl text-slate-800 leading-tight">
            {{ __('Pharmacy Dashboard Overview') }}
        </h2>
        
        <div class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4 bg-white p-3 sm:p-4 rounded-xl shadow-sm border border-slate-200 items-stretch sm:items-center w-full md:w-auto">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 w-full sm:w-auto">
                    <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] whitespace-nowrap sm:whitespace-normal">{{ __('Branch:') }}</span>
                    <select wire:model.live="selectedBranch" class="border-slate-200 bg-slate-50 focus:border-blue-400 focus:ring-blue-400 focus:bg-white rounded-lg shadow-sm text-sm h-9 w-full sm:min-w-[150px] text-slate-600">
                        <option value="">{{ __('All Branches') }}</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 w-full sm:w-auto">
                    <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] whitespace-nowrap sm:whitespace-normal">{{ __('From:') }}</span>
                    <input type="date" wire:model="startDate" class="border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm h-9 w-full sm:w-auto text-slate-700">
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 w-full sm:w-auto">
                    <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] whitespace-nowrap sm:whitespace-normal">{{ __('To:') }}</span>
                    <input type="date" wire:model="endDate" class="border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm h-9 w-full sm:w-auto text-slate-700">
                </div>
                <button wire:click="filter" class="bg-blue-500 text-white px-4 sm:px-6 py-2 h-9 rounded-lg text-sm font-medium hover:bg-blue-600 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 w-full sm:w-auto">
                    {{ __('Update') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Today's Highlights -->
    <div class="mb-8">
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">{{ __('Today\'s Highlights') }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Today's Sales -->
            <div class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl p-4 text-white shadow-md">
                <div class="flex justify-between items-start mb-2">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m.599-1H11.401m.002 0a6.7 6.7 0 01-1.393-1.04C10.311 15.01 10 14.524 10 14m0 0c0-.895 1.343-2 3-2M10 14c0 .895 1.343 2 3 2m3-2c0 .895-1.343-2-3-2m3 2c0 .895-1.343 2-3 2" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium bg-blue-600/50 px-2 py-1 rounded-full">Today</span>
                </div>
                <p class="text-blue-50 text-xs font-medium mb-1">{{ __('Sales Revenue') }}</p>
                <p class="text-2xl font-bold">${{ number_format($todaySales, 2) }}</p>
            </div>

            <!-- Transactions -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-slate-500 text-xs font-medium mb-1">{{ __('Transactions') }}</p>
                <div class="flex items-baseline space-x-2">
                    <p class="text-2xl font-bold text-slate-800">{{ $todayTransactions }}</p>
                    <span class="text-xs text-slate-400">{{ __('orders') }}</span>
                </div>
            </div>

            <!-- Net Cash -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <p class="text-slate-500 text-xs font-medium mb-1">{{ __('Net Cash Trend') }}</p>
                <p class="text-2xl font-bold {{ $todayNetCash >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    {{ $todayNetCash >= 0 ? '+' : '' }}${{ number_format($todayNetCash, 2) }}
                </p>
            </div>

            <!-- New Customers -->
            <div class="bg-gradient-to-br from-cyan-400 to-cyan-500 rounded-xl p-4 text-white shadow-md">
                <div class="flex justify-between items-start mb-2">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                </div>
                <p class="text-cyan-50 text-xs font-medium mb-1">{{ __('New Customers') }}</p>
                <div class="flex items-baseline space-x-2">
                    <p class="text-2xl font-bold">{{ $newCustomersToday }}</p>
                    <span class="text-xs text-cyan-50">{{ __('registered') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Sales -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-blue-300 transition-colors">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-50/80 text-blue-500 rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m.599-1H11.401m.002 0a6.7 6.7 0 01-1.393-1.04C10.311 15.01 10 14.524 10 14m0 0c0-.895 1.343-2 3-2M10 14c0 .895 1.343 2 3 2m3-2c0 .895-1.343-2-3-2m3 2c0 .895-1.343 2-3 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Total Sales') }}</p>
                    <p class="text-xl font-bold text-slate-800">${{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Purchases -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-emerald-300 transition-colors">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-emerald-50/80 text-emerald-500 rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Total Purchases') }}</p>
                    <p class="text-xl font-bold text-slate-800">${{ number_format($totalPurchases, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-rose-300 transition-colors">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-rose-50/80 text-rose-500 rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Expenses') }}</p>
                    <p class="text-xl font-bold text-slate-800">${{ number_format($totalExpenses, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-amber-300 transition-colors">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-amber-50/80 text-amber-500 rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Low Stock Items') }}</p>
                    <p class="text-xl font-bold text-slate-800">{{ $lowStockCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Stats / Charts -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Top Selling Products -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">{{ __('Top Selling Products') }}</h3>
                        <p class="text-xs text-slate-400">{{ __('By quantity sold') }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    @forelse($topProductsSelectedRange as $item)
                    <div class="relative">
                        <div class="flex justify-between text-sm font-medium text-slate-700 mb-1 z-10 relative">
                            <span>{{ $item->product->name }}</span>
                            <span class="font-bold">{{ $item->total_qty }} {{ __('sold') }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            @php
                                $maxQty = $topProductsSelectedRange->max('total_qty');
                                $percentage = $maxQty > 0 ? ($item->total_qty / $maxQty) * 100 : 0;
                            @endphp
                            <div class="bg-gradient-to-r from-blue-400 to-cyan-400 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @empty
                        <div class="text-center text-slate-400 py-4 italic text-sm">{{ __('No sales recorded for this period') }}</div>
                    @endforelse
                </div>
            </div>

            <!-- Cash Movement Analysis -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">{{ __('Cash Movement Analysis') }}</h3>
                        <p class="text-xs text-slate-400">{{ __('Comparison of sales, expenses and net cash') }}</p>
                    </div>
                </div>
                <div class="relative h-80" wire:ignore>
                    <canvas id="cashMovementChart"></canvas>
                </div>
            </div>

            <!-- Cash Growth Trend -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">{{ __('Cash Growth Trend') }}</h3>
                        <p class="text-xs text-slate-400">{{ __('Cumulative net cash balance over time') }}</p>
                    </div>
                </div>
                <div class="relative h-80" wire:ignore>
                    <canvas id="cashGrowthChart"></canvas>
                </div>
            </div>

            <!-- Customer Growth Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">{{ __('Customer Growth') }}</h3>
                        <p class="text-xs text-slate-400">Total customers: {{ $totalCustomers }}</p>
                    </div>
                </div>
                <div class="flex items-end justify-between space-x-2 h-48">
                    @forelse($customerGrowth as $day)
                        <div class="flex-1 bg-blue-200 rounded-t-lg group relative hover:bg-blue-300 transition-all duration-200" 
                             style="height: {{ ($customerGrowth->max('count') > 0 ? ($day->count / $customerGrowth->max('count')) : 0) * 100 }}%">
                             <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] px-2 py-1 rounded shadow-xl opacity-0 group-hover:opacity-100 transition whitespace-nowrap z-10">
                                {{ $day->date }}: {{ $day->count }}
                             </div>
                        </div>
                    @empty
                        <div class="w-full flex items-center justify-center text-slate-300 italic text-sm">No data available</div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Sales Table -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-slate-100">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">{{ __('Recent Sales') }}</h3>
                </div>
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle px-4 sm:px-0">
                        <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Invoice') }}</th>
                                <th class="px-3 sm:px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest hidden sm:table-cell">{{ __('Customer') }}</th>
                                <th class="px-3 sm:px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Total') }}</th>
                                <th class="px-3 sm:px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentSales as $sale)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700 text-center">
                                    <a href="{{ route('admin.sales.print', $sale) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        #{{ $sale->invoice_no }}
                                    </a>
                                    <div class="text-xs text-slate-500 sm:hidden">{{ $sale->customer->name ?? __('Walk-in') }}</div>
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-600 hidden sm:table-cell text-center">{{ $sale->customer->name ?? __('Walk-in') }}</td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-500 text-center">${{ number_format($sale->total, 2) }}</td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $sale->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst($sale->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Stocktakes Table -->
            @if(count($recentStocktakes) > 0)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">{{ __('Recent Stocktakes') }}</h3>
                    <a href="{{ route('admin.stocktakes.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">{{ __('View All') }}</a>
                </div>
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle px-4 sm:px-0">
                        <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Ref') }}</th>
                                <th class="px-3 sm:px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest hidden sm:table-cell">{{ __('Store') }}</th>
                                <th class="px-3 sm:px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Date') }}</th>
                                <th class="px-3 sm:px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentStocktakes as $st)
                            <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="window.location='{{ route('admin.stocktakes.show', $st->id) }}'">
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700 text-center">
                                    {{ $st->reference }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-600 hidden sm:table-cell text-center">{{ $st->store->name }}</td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-600 text-center">{{ $st->date->format('M d, Y') }}</td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                        {{ $st->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                           ($st->status === 'pending_approval' ? 'bg-yellow-100 text-yellow-700' : 
                                           ($st->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $st->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <!-- Smaller Stats Cards -->
            <div class="grid grid-cols-1 gap-6">
                
                <!-- Stocktake Actions -->
                @if($pendingStocktakesCount > 0 || $approvedStocktakesCount > 0 || $rejectedStocktakesCount > 0)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">{{ __('Stocktake Status') }}</h3>
                    <div class="space-y-4">
                        <!-- Pending -->
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                            <div class="flex items-center space-x-3">
                                <div class="bg-yellow-100 text-yellow-600 p-2 rounded-lg">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-700">{{ __('Pending') }}</span>
                            </div>
                            <span class="text-lg font-bold text-yellow-700">{{ $pendingStocktakesCount }}</span>
                        </div>
                        
                        <!-- Approved -->
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-100">
                            <div class="flex items-center space-x-3">
                                <div class="bg-green-100 text-green-600 p-2 rounded-lg">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-700">{{ __('Approved') }}</span>
                            </div>
                            <span class="text-lg font-bold text-green-700">{{ $approvedStocktakesCount }}</span>
                        </div>

                        <!-- Rejected -->
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                            <div class="flex items-center space-x-3">
                                <div class="bg-red-100 text-red-600 p-2 rounded-lg">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-700">{{ __('Rejected') }}</span>
                            </div>
                            <span class="text-lg font-bold text-red-700">{{ $rejectedStocktakesCount }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Branches -->
                <div class="bg-indigo-500 rounded-xl p-6 shadow-md text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-bold text-indigo-50 uppercase tracking-widest mb-1">{{ __('Active Branches') }}</p>
                            <p class="text-3xl font-black">{{ $activeBranches }}</p>
                        </div>
                        <div class="p-2 bg-indigo-400/50 rounded-lg">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Users -->
                <div class="bg-purple-500 rounded-xl p-6 shadow-md text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-bold text-purple-50 uppercase tracking-widest mb-1">{{ __('Total Users') }}</p>
                            <p class="text-3xl font-black">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-2 bg-purple-400/50 rounded-lg">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function initCashMovementChart(data) {
        const ctx = document.getElementById('cashMovementChart');
        if (!ctx) return;

        const existingChart = Chart.getChart(ctx);
        if (existingChart) {
            existingChart.destroy();
        }

        if (!data) {
            data = @json($cashMovementData);
        }

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: '{{ __('Sales') }}',
                        data: data.sales,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1,
                        borderRadius: 4,
                        order: 2
                    },
                    {
                        label: '{{ __('Expenses') }}',
                        data: data.expenses,
                        backgroundColor: 'rgba(244, 63, 94, 0.7)',
                        borderColor: 'rgb(244, 63, 94)',
                        borderWidth: 1,
                        borderRadius: 4,
                        order: 2
                    },
                    {
                        label: '{{ __('Net Cash') }}',
                        data: data.netCash,
                        type: 'line',
                        borderColor: '#8b5cf6',
                        backgroundColor: '#8b5cf6',
                        borderWidth: 3,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: false,
                        tension: 0.4,
                        order: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        padding: 12,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 },
                        cornerRadius: 8,
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            font: { size: 10 },
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 10 }
                        }
                    }
                }
            }
        });
    }

    function initCashGrowthChart(data) {
        const ctx = document.getElementById('cashGrowthChart');
        if (!ctx) return;

        const existingChart = Chart.getChart(ctx);
        if (existingChart) {
            existingChart.destroy();
        }

        if (!data) {
            data = @json($cashGrowthData);
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: '{{ __('Cumulative Balance') }}',
                        data: data.data,
                        fill: true,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderColor: '#10b981',
                        borderWidth: 3,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        padding: 12,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': $' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => {
            initCashMovementChart();
            initCashGrowthChart();
            initTopProductsChart();
        }, 100);
    });
    
    document.addEventListener('livewire:initialized', () => {
        initCashMovementChart();
        initCashGrowthChart();
        
        Livewire.on('statsUpdated', (eventData) => {
            const data = eventData[0];
            setTimeout(() => {
                initCashMovementChart(data.movement);
                initCashGrowthChart(data.growth);
            }, 100);
        });
    });
</script>
@endpush
