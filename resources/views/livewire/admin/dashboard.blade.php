<div x-data="{ startDate: '{{ $startDate }}', endDate: '{{ $endDate }}' }">
    <!-- Header with Date Filter -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 sm:mb-6 gap-4">
        <h2 class="font-semibold text-lg sm:text-xl text-slate-800 leading-tight">
            {{ __('Pharmacy Dashboard Overview') }}
        </h2>
        
        <div class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4 bg-white p-3 sm:p-4 rounded-xl shadow-sm border border-slate-200 items-stretch sm:items-center w-full md:w-auto">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <div class="flex items-center">
                    <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] mr-2 whitespace-nowrap">Branch:</span>
                    <select wire:model.live="selectedBranch" class="border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm w-full sm:min-w-[150px] text-slate-700">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center">
                    <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] mr-2 whitespace-nowrap">From:</span>
                    <input type="date" wire:model="startDate" class="border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm w-full sm:w-auto text-slate-700">
                </div>
                <div class="flex items-center">
                    <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] mr-2 whitespace-nowrap">To:</span>
                    <input type="date" wire:model="endDate" class="border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm w-full sm:w-auto text-slate-700">
                </div>
                <button wire:click="filter" class="bg-blue-600 text-white px-4 sm:px-6 py-2 rounded-lg text-sm font-bold uppercase tracking-widest hover:bg-blue-700 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 w-full sm:w-auto">
                    Update
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Sales -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-blue-300 transition-colors">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m.599-1H11.401m.002 0a6.7 6.7 0 01-1.393-1.04C10.311 15.01 10 14.524 10 14m0 0c0-.895 1.343-2 3-2M10 14c0 .895 1.343 2 3 2m3-2c0 .895-1.343-2-3-2m3 2c0 .895-1.343 2-3 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Sales</p>
                    <p class="text-xl font-bold text-slate-800">${{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Purchases -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-emerald-300 transition-colors">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Purchases</p>
                    <p class="text-xl font-bold text-slate-800">${{ number_format($totalPurchases, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-rose-300 transition-colors">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Expenses</p>
                    <p class="text-xl font-bold text-slate-800">${{ number_format($totalExpenses, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:border-amber-300 transition-colors">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Low Stock Items</p>
                    <p class="text-xl font-bold text-slate-800">{{ $lowStockCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Stats / Charts -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Customer Growth Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Customer Growth</h3>
                        <p class="text-xs text-slate-400">Total customers: {{ $totalCustomers }}</p>
                    </div>
                </div>
                <div class="flex items-end justify-between space-x-2 h-48">
                    @forelse($customerGrowth as $day)
                        <div class="flex-1 bg-blue-100 rounded-t-lg group relative hover:bg-blue-400 transition-all duration-200" 
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
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">Recent Sales</h3>
                </div>
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle px-4 sm:px-0">
                        <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Invoice</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest hidden sm:table-cell">Customer</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Total</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentSales as $sale)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    <div>#{{ $sale->invoice_no }}</div>
                                    <div class="text-xs text-slate-500 sm:hidden">{{ $sale->customer->name ?? 'Walk-in' }}</div>
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-600 hidden sm:table-cell">{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">${{ number_format($sale->total, 2) }}</td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $sale->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
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
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <!-- Smaller Stats Cards -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Branches -->
                <div class="bg-indigo-600 rounded-xl p-6 shadow-lg shadow-indigo-200 text-white border border-indigo-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest mb-1">Active Branches</p>
                            <p class="text-3xl font-black">{{ $activeBranches }}</p>
                        </div>
                        <div class="p-2 bg-indigo-500/50 rounded-lg">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Users -->
                <div class="bg-purple-600 rounded-xl p-6 shadow-lg shadow-purple-200 text-white border border-purple-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-bold text-purple-100 uppercase tracking-widest mb-1">Total Users</p>
                            <p class="text-3xl font-black">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-2 bg-purple-500/50 rounded-lg">
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
