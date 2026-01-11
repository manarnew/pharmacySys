<div x-data="{ startDate: '', endDate: '' }">
    <!-- Header with Date Filter -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4 md:mb-0">
            {{ __('Dashboard Overview') }}
        </h2>
        
        <div class="flex space-x-4 bg-white p-2 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center">
                <span class="text-gray-500 text-sm mr-2">From:</span>
                <input type="date" x-model="startDate" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
            </div>
            <div class="flex items-center">
                <span class="text-gray-500 text-sm mr-2">To:</span>
                <input type="date" x-model="endDate" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
            </div>
            <button class="bg-blue-600 text-white px-4 py-1 rounded-md text-sm hover:bg-blue-700 transition">
                Filter
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Patients -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                     <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Patients</h3>
                    <p class="text-2xl font-bold text-gray-800">1,254</p>
                </div>
            </div>
        </div>



        <!-- Active Clinics -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Active Clinics</h3>
                    <p class="text-2xl font-bold text-gray-800">8</p>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Monthly Revenue</h3>
                    <p class="text-2xl font-bold text-gray-800">$45,200</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">


         <!-- Revenue by Clinic -->
         <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Revenue by Clinic</h3>
                <span class="text-xs text-gray-500" x-show="startDate || endDate">
                    Filtering: <span x-text="startDate"></span> to <span x-text="endDate"></span>
                </span>
            </div>
            <div class="h-64 bg-gray-50 flex items-center justify-center rounded border border-dashed border-gray-300 relative">
                 <div class="text-center">
                    <p class="text-gray-400 mb-2">Chart Placeholder (Pie/Bar Visualization)</p>
                    <div class="flex space-x-2 justify-center items-end h-32">
                        <div class="h-1/2 w-8 bg-purple-300 rounded-t"></div>
                        <div class="h-3/4 w-8 bg-purple-500 rounded-t"></div>
                        <div class="h-1/3 w-8 bg-purple-200 rounded-t"></div>
                        <div class="h-full w-8 bg-purple-600 rounded-t"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</div>
