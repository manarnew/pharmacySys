<div x-data="{ startDate: '', endDate: '' }">
    <!-- Header with Date Filter -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight mb-4 md:mb-0">
            {{ __('Dashboard Overview') }}
        </h2>
        
        <div class="flex flex-wrap gap-4 bg-white p-3 rounded-xl shadow-sm border border-slate-200 items-center">
            <div class="flex items-center">
                <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] mr-2">Clinic:</span>
                <select wire:model="selectedClinic" class="border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm min-w-[150px] text-slate-700">
                    <option value="">All Clinics</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center">
                <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] mr-2">From:</span>
                <input type="date" wire:model="startDate" class="border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm text-slate-700">
            </div>
            <div class="flex items-center">
                <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] mr-2">To:</span>
                <input type="date" wire:model="endDate" class="border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm text-slate-700">
            </div>
            <button wire:click="filter" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-bold uppercase tracking-widest hover:bg-blue-700 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Update
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Total Patients -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                     <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-4.42 6.753 6.753 0 01-1.481-1.296 2.25 2.25 0 00-2.435-.756 2.25 2.25 0 00-1.875 1.875 2.5 2.5 0 00.965 3.493z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-slate-600">Total Patients</h3>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($totalPatients) }}</p>
                </div>
            </div>
        </div>

        <!-- Monthly Expenses -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                        <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                        <path d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-slate-600">Expenses</h3>
                    <p class="text-2xl font-bold text-slate-800">${{ number_format($totalExpenses, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Clinics -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5H16.5a.75.75 0 000-1.5H15.75V2.25A.75.75 0 0015 1.5H3.75a.75.75 0 00-.75.75zM4.5 3.75h9.75v15.75H4.5V3.75z" clip-rule="evenodd" />
                        <path d="M18.75 7.5a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V8.25a.75.75 0 00-.75-.75h-.008zM18.75 10.5a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V11.25a.75.75 0 00-.75-.75h-.008zM18.75 13.5a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75v-.008a.75.75 0 00-.75-.75h-.008z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-slate-600">Total Clinics</h3>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($activeClinics) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M5.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM2.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM18.75 7.5a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 16.5a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-slate-600">System Users</h3>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($totalUsers) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <!-- Operational Stats -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-6">Operational Volume</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                    <div class="text-indigo-600 mb-1">
                        <i class="fas fa-notes-medical text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-indigo-900">{{ number_format($totalExams) }}</div>
                    <div class="text-xs font-medium text-indigo-500 uppercase">Examinations</div>
                </div>
                <div class="p-4 bg-purple-50 rounded-xl border border-purple-100">
                    <div class="text-purple-600 mb-1">
                        <i class="fas fa-file-prescription text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-purple-900">{{ number_format($totalPrescriptions) }}</div>
                    <div class="text-xs font-medium text-purple-500 uppercase">Prescriptions</div>
                </div>
            </div>
            
            <div class="mt-6 p-4 rounded-xl border border-dashed border-slate-300">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Order Conversion Rate</span>
                    <span class="font-bold text-slate-900">
                        {{ $totalExams > 0 ? number_format(($totalOrders / $totalExams) * 100, 1) : 0 }}%
                    </span>
                </div>
                <div class="mt-2 w-full bg-slate-100 rounded-full h-1.5">
                    @php
                        $convRate = $totalExams > 0 ? ($totalOrders / $totalExams) * 100 : 0;
                    @endphp
                    <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ min($convRate, 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Detailed Trends Section (Patient Growth Trend) -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-6 flex justify-between items-center">
                <span>Patient Growth Trend</span>
                <span class="text-xs font-normal text-slate-400">Activity in period</span>
            </h3>
            <div class="flex items-end justify-between space-x-1 h-32">
                @forelse($patientGrowth as $day)
                    @php $maxCount = $patientGrowth->max('count'); @endphp
                    <div class="flex-1 bg-indigo-100 rounded-t-md group relative hover:bg-indigo-300 transition-all duration-200" 
                         style="height: {{ ($maxCount > 0 ? ($day->count / $maxCount) : 0) * 100 }}%">
                         <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] px-2 py-1 rounded shadow-xl opacity-0 group-hover:opacity-100 transition whitespace-nowrap z-10">
                            {{ $day->date }}: {{ $day->count }} patients
                         </div>
                    </div>
                @empty
                    <div class="flex-1 flex flex-col items-center justify-center text-slate-400 text-sm italic">
                        <i class="fas fa-chart-line mb-2 text-2xl opacity-20"></i>
                        No activity recorded
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
