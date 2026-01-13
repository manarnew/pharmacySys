<div class="max-w-6xl mx-auto p-4 space-y-6">
    
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Prescription Details</h1>
             <div class="flex items-center mt-2 space-x-2 text-sm text-slate-500">
                <span>Patient:</span>
                <span class="font-semibold text-slate-900">{{ $patient->name ?? 'N/A' }}</span>
                <span class="bg-blue-100 text-blue-700 py-0.5 px-2 rounded-full text-xs font-medium">#{{ $patient->id ?? '' }}</span>
            </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
             <div class="flex items-center justify-end space-x-4">
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Prescription ID</p>
                    <p class="text-lg font-bold text-slate-900">#{{ $prescription->id }}</p>
                </div>
                 <div class="text-right border-l border-slate-200 pl-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date Issued</p>
                    <p class="text-lg font-bold text-slate-900">{{ $prescription->created_at->format('F d, Y') }}</p>
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
    
    <!-- Prescription Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Prescription Values</h3>
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
                    <!-- OD -->
                    <tr>
                         <td class="px-4 py-3 text-center font-bold text-blue-600 bg-blue-50/50 border-r border-slate-200">OD</td>
                         <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->sphere_od ?: '-' }}</td>
                         <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->cyl_od ?: '-' }}</td>
                         <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->axis_od ?: '-' }}</td>
                         <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->add_od ?: '-' }}</td>
                         <td class="px-4 py-3 text-center font-medium text-slate-900">{{ $prescription->va_od ?: '-' }}</td>
                    </tr>
                    <!-- OS -->
                    <tr>
                         <td class="px-4 py-3 text-center font-bold text-green-600 bg-green-50/50 border-r border-slate-200">OS</td>
                         <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->sphere_os ?: '-' }}</td>
                         <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->cyl_os ?: '-' }}</td>
                         <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->axis_os ?: '-' }}</td>
                         <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->add_os ?: '-' }}</td>
                         <td class="px-4 py-3 text-center font-medium text-slate-900">{{ $prescription->va_os ?: '-' }}</td>
                    </tr>
                </tbody>
             </table>
        </div>
    </div>
    
    <!-- Extra Fields -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- IPD -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col justify-center">
             <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-2">IPD Measurement</h3>
             <p class="text-2xl font-bold text-slate-900">{{ $prescription->ipd ?: '-' }} <span class="text-sm font-normal text-slate-500">mm</span></p>
        </div>
        
         <!-- Notes -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
              <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-2">Clinical Notes</h3>
              <div class="bg-slate-50 rounded-lg p-4 border border-slate-100 text-slate-700 min-h-[80px]">
                 {{ $prescription->notes ?: 'No notes recorded' }}
              </div>
        </div>
    </div>
    
    <!-- Specialist Footer -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex justify-between items-center">
        <div class="flex items-center space-x-3">
             <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
             </div>
             <div>
                <p class="text-sm font-medium text-slate-500">Prescribing Specialist</p>
                <p class="font-bold text-slate-900">{{ $prescription->specialist->name ?? 'N/A' }}</p>
             </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4 print:hidden">
        <button onclick="window.print()" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 shadow-sm text-base font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
             <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
             Print
        </button>
        
        <a href="{{ route('admin.orders.create', ['patient_id' => $patient->id, 'prescription_id' => $prescription->id]) }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
             Create Order
        </a>
        
        <a href="{{ route('admin.prescriptions.index', ['prescription_id' => $prescription->id]) }}" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 shadow-sm text-base font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
             <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
             Edit
        </a>
    </div>

    <!-- Simple Print Styles -->
    <style>
        @media print {
            .print\:hidden { display: none !important; }
            body { background: white; }
            .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl, .shadow-2xl { box-shadow: none !important; }
            .border { border: 1px solid #ddd !important; }
        }
    </style>
</div>