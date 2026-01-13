<div class="max-w-6xl mx-auto p-4 space-y-6">
    
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Examination Details</h1>
            <div class="flex items-center mt-2 space-x-2 text-sm text-slate-500">
                <span>Patient:</span>
                <span class="font-semibold text-slate-900">{{ $patient->name }}</span>
                <span class="bg-blue-100 text-blue-700 py-0.5 px-2 rounded-full text-xs font-medium">#{{ $patient->id }}</span>
            </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
             <div class="flex items-center justify-end space-x-4">
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Exam ID</p>
                    <p class="text-lg font-bold text-slate-900">#{{ $examination->id }}</p>
                </div>
                 <div class="text-right border-l border-slate-200 pl-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</p>
                    <p class="text-lg font-bold text-slate-900">{{ $examination->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Age -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center space-x-4">
            <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Age</p>
                <p class="text-xl font-bold text-slate-900">{{ $patient->age ?? 'N/A' }} <span class="text-sm font-normal text-slate-400">years</span></p>
            </div>
        </div>
        <!-- Phone -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center space-x-4">
            <div class="p-3 bg-green-50 rounded-lg text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
            </div>
             <div>
                <p class="text-sm font-medium text-slate-500">Phone</p>
                <p class="text-xl font-bold text-slate-900">{{ $patient->phone ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Medical History -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Medical History
        </h2>
        <div class="bg-slate-50 rounded-lg p-4 border border-slate-100 text-slate-700">
             {{ $examination->history ?: 'No medical history recorded' }}
        </div>
    </div>

    <!-- Results Action Header -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex justify-between items-center">
         <h2 class="text-lg font-bold text-slate-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
             Examination Results
        </h2>
    </div>

    <!-- Old RX Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Previous Prescription (Old RX)</h3>
            <button wire:click="convertToPrescription('old_rx')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transition-colors">
                Convert to Prescription
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-center border-r border-slate-200 w-16">Eye</th>
                        <th class="px-4 py-3 text-center border-r border-slate-200">Sphere</th>
                        <th class="px-4 py-3 text-center border-r border-slate-200">CYL</th>
                        <th class="px-4 py-3 text-center border-r border-slate-200">AXIS</th>
                        <th class="px-4 py-3 text-center border-r border-slate-200">ADD</th>
                        <th class="px-4 py-3 text-center">VA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                     <!-- OD Row -->
                    <tr>
                        <td class="px-4 py-3 text-center font-bold text-blue-600 bg-blue-50/50 border-r border-slate-200">OD</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->old_sphere_od ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->old_cyl_od ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->old_axis_od ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->old_add_od ?: '-' }}</td>
                        <td class="px-4 py-3 text-center font-medium text-slate-900">{{ $examination->old_va_od ?: '-' }}</td>
                    </tr>
                    <!-- OS Row -->
                    <tr>
                        <td class="px-4 py-3 text-center font-bold text-green-600 bg-green-50/50 border-r border-slate-200">OS</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->old_sphere_os ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->old_cyl_os ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->old_axis_os ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->old_add_os ?: '-' }}</td>
                        <td class="px-4 py-3 text-center font-medium text-slate-900">{{ $examination->old_va_os ?: '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Subjective RX Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Subjective Refraction</h3>
            <button wire:click="convertToPrescription('subjective')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-md transition-colors">
                Convert to Prescription
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-center border-r border-slate-200 w-16">Eye</th>
                        <th class="px-4 py-3 text-center border-r border-slate-200">Sphere</th>
                        <th class="px-4 py-3 text-center border-r border-slate-200">CYL</th>
                        <th class="px-4 py-3 text-center border-r border-slate-200">AXIS</th>
                        <th class="px-4 py-3 text-center border-r border-slate-200">ADD</th>
                        <th class="px-4 py-3 text-center">VA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                     <!-- OD Row -->
                    <tr>
                        <td class="px-4 py-3 text-center font-bold text-blue-600 bg-blue-50/50 border-r border-slate-200">OD</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->subj_sphere_od ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->subj_cyl_od ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->subj_axis_od ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->subj_add_od ?: '-' }}</td>
                        <td class="px-4 py-3 text-center font-medium text-slate-900">{{ $examination->subj_va_od ?: '-' }}</td>
                    </tr>
                    <!-- OS Row -->
                    <tr>
                        <td class="px-4 py-3 text-center font-bold text-green-600 bg-green-50/50 border-r border-slate-200">OS</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->subj_sphere_os ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->subj_cyl_os ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->subj_axis_os ?: '-' }}</td>
                        <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $examination->subj_add_os ?: '-' }}</td>
                        <td class="px-4 py-3 text-center font-medium text-slate-900">{{ $examination->subj_va_os ?: '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
     
    <!-- Specialist Footer -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex justify-between items-center">
        <div class="flex items-center space-x-3">
             <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
             </div>
             <div>
                <p class="text-sm font-medium text-slate-500">Examining Specialist</p>
                <p class="font-bold text-slate-900">{{ $examination->specialist->name ?? 'N/A' }}</p>
             </div>
        </div>
    </div>
</div>