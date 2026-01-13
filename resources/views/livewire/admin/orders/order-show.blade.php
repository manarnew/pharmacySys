<div class="max-w-6xl mx-auto p-4 space-y-6">
    
    <!-- Order Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">Optical Order Details</h1>
            <p class="text-slate-500 text-sm font-medium mt-1">Invoice: <span class="font-mono text-slate-700">{{ $order->invoice_no }}</span></p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-3">
             <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($order->status) }}
            </span>
             <span class="text-sm text-slate-500">{{ $order->created_at->format('F d, Y') }}</span>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Left Column: Patient & Order Info -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Patient & Order Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Information</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Patient Info -->
                    <div>
                        <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Patient Details</h4>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-slate-900">{{ $patient->name ?? 'N/A' }}</p>
                                <p class="text-slate-600 text-sm">{{ $patient->phone ?? 'No phone' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Destination Info -->
                    <div>
                        <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Order Destination</h4>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-purple-50 rounded-lg">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-slate-900">{{ $order->destination ?? 'N/A' }}</p>
                                <p class="text-slate-600 text-sm">Target Location</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lens Specifications -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Lens Specifications</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Frame</p>
                            <p class="font-bold text-slate-900">{{ $order->frame_type ?: '-' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Index</p>
                            <p class="font-bold text-slate-900">{{ $order->lens_index ?: '-' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Type</p>
                            <p class="font-bold text-slate-900">{{ $order->lens_type ?: '-' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Photo</p>
                            <p class="font-bold text-slate-900">{{ $order->photo ?: '-' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Package</p>
                            <p class="font-bold text-slate-900">{{ $order->package ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referenced Prescription -->
            @if($prescription)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Associated Prescription</h3>
                    <span class="text-xs font-mono text-slate-500 bg-slate-200 px-2 py-1 rounded">#{{ $prescription->id }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-2 text-center border-r border-slate-200 w-16">Eye</th>
                                <th class="px-4 py-2 text-center border-r border-slate-200">Sph</th>
                                <th class="px-4 py-2 text-center border-r border-slate-200">Cyl</th>
                                <th class="px-4 py-2 text-center border-r border-slate-200">Axis</th>
                                <th class="px-4 py-2 text-center">Add</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <tr>
                                <td class="px-4 py-3 text-center font-bold text-blue-600 bg-blue-50/50 border-r border-slate-200">OD</td>
                                <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->sphere_od }}</td>
                                <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->cyl_od }}</td>
                                <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->axis_od }}</td>
                                <td class="px-4 py-3 text-center font-medium text-slate-900">{{ $prescription->add_od }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-center font-bold text-green-600 bg-green-50/50 border-r border-slate-200">OS</td>
                                <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->sphere_os }}</td>
                                <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->cyl_os }}</td>
                                <td class="px-4 py-3 text-center border-r border-slate-200 font-medium text-slate-900">{{ $prescription->axis_os }}</td>
                                <td class="px-4 py-3 text-center font-medium text-slate-900">{{ $prescription->add_os }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>

        <!-- Right Column: Sidebar Actions & Notes -->
        <div class="space-y-6">
            
            <!-- Actions Card -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4">Actions</h3>
                <div class="space-y-3">
                    <button onclick="window.print()" class="w-full flex justify-center items-center space-x-2 px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Print Order</span>
                    </button>
                    
                    <a href="{{ route('admin.dashboard') }}" class="w-full flex justify-center items-center space-x-2 px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-colors">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Notes Card -->
            <div class="bg-orange-50 rounded-xl shadow-sm border border-orange-100 p-6">
                <div class="flex items-center space-x-2 mb-3">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <h3 class="text-sm font-bold text-orange-800 uppercase tracking-wider">Special Instructions</h3>
                </div>
                <p class="text-orange-900 text-sm leading-relaxed">
                    {{ $order->notes ?: 'No special instructions recorded for this order.' }}
                </p>
            </div>

            <!-- Meta Info -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4">Metadata</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Created By</span>
                        <span class="font-medium text-slate-900">{{ $order->creator->name ?? 'System' }}</span>
                    </div>
                     <div class="flex justify-between">
                        <span class="text-slate-500">Last Updated</span>
                        <span class="font-medium text-slate-900">{{ $order->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body {
                background: white !important;
            }
            .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl, .shadow-2xl {
                box-shadow: none !important;
            }
            .grid {
                display: block !important;
            }
            .col-span-2 {
                width: 100% !important;
            }
            button, a[href] {
                display: none !important;
            }
            .bg-slate-50, .bg-blue-50, .bg-purple-50, .bg-orange-50 {
                background-color: white !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
</div>