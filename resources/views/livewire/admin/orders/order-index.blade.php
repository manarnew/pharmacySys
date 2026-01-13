<div class="max-w-6xl mx-auto p-4 space-y-6">
    
    <!-- Display Success Message -->
    @if (session()->has('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 mb-6">
             <div class="flex items-center space-x-3">
                 <div class="p-1 bg-green-100 rounded-full text-green-600">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                 </div>
                 <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Form Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">New Optical Order</h2>
                <p class="text-slate-500 text-sm mt-1">Complete patient information and lens specifications</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="flex items-center space-x-3 bg-slate-50 border border-slate-200 rounded-lg px-4 py-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Order Date</p>
                        <p class="text-sm font-bold text-slate-900">{{ now()->format('l, F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex items-center space-x-3">
             <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 uppercase tracking-wide">Patient Information</h3>
        </div>
        <div class="p-6">
             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Patient Name -->
                <div class="bg-slate-50 rounded-lg border border-slate-200 p-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Patient Name</label>
                    <div class="text-lg font-bold text-slate-900">{{ $patient->name ?? 'N/A' }}</div>
                </div>

                <!-- Patient Phone -->
                <div class="bg-slate-50 rounded-lg border border-slate-200 p-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Phone Number</label>
                    <div class="text-lg font-bold text-slate-900">{{ $patient->phone ?? 'N/A' }}</div>
                </div>

                <!-- Invoice No -->
                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Invoice No <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model="invoice_no"
                            placeholder="INV-000008"
                            class="w-full text-base font-semibold text-slate-900 bg-white border border-slate-300 rounded-lg pl-10 pr-4 py-2.5 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        />
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" /></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lens Specifications Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex items-center space-x-3">
            <div class="p-2 bg-indigo-100 rounded-lg">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 uppercase tracking-wide">Lens Specifications</h3>
        </div>
        
        <div class="p-6">
            <div class="overflow-x-auto rounded-lg border border-slate-200 shadow-sm">
                <table class="w-full border-collapse bg-white">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Frame</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Index</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Package</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- Frame -->
                            <td class="px-6 py-4 border-b border-slate-100">
                                <select wire:model="frame_type" class="w-full text-sm border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-slate-900 bg-white py-2">
                                    <option value="" class="text-slate-500">Select Frame</option>
                                    <option>Dry Root</option>
                                    <option>Full Rim</option>
                                    <option>Semi-Rimless</option>
                                    <option>Rimless</option>
                                    <option>Sports</option>
                                    <option>Children</option>
                                </select>
                            </td>
                            <!-- Index -->
                            <td class="px-6 py-4 border-b border-slate-100">
                                <select wire:model="lens_index" class="w-full text-sm border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-slate-900 bg-white py-2">
                                    <option value="" class="text-slate-500">Select Index</option>
                                    <option>1.56</option>
                                    <option>1.59</option>
                                    <option>1.67</option>
                                    <option>1.74</option>
                                </select>
                            </td>
                            <!-- Type -->
                            <td class="px-6 py-4 border-b border-slate-100">
                                <select wire:model="lens_type" class="w-full text-sm border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-slate-900 bg-white py-2">
                                    <option value="" class="text-slate-500">Select Type</option>
                                    <option>Single Vision</option>
                                    <option>Bifocal</option>
                                    <option>Progressive</option>
                                    <option>Occupational</option>
                                </select>
                            </td>
                            <!-- Photo -->
                            <td class="px-6 py-4 border-b border-slate-100">
                                <select wire:model="photo" class="w-full text-sm border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-slate-900 bg-white py-2">
                                    <option value="" class="text-slate-500">Select Photo</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <!-- Package -->
                            <td class="px-6 py-4 border-b border-slate-100">
                                <select wire:model="package" class="w-full text-sm border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-slate-900 bg-white py-2">
                                    <option value="" class="text-slate-500">Select Package</option>
                                    <option>Prime</option>
                                    <option>Plus</option>
                                    <option>Premium</option>
                                    <option>Ultra</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Additional Details Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex items-center space-x-3">
             <div class="p-2 bg-amber-100 rounded-lg">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 uppercase tracking-wide">Additional Details</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Notes Section -->
                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-700 mb-2">Notes & Special Instructions</label>
                    <textarea 
                        wire:model="notes" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-slate-900 bg-white shadow-sm"
                        placeholder="Any special requirements, patient preferences, or additional notes..."></textarea>
                    <p class="text-xs text-slate-500 mt-2 text-right">Maximum 500 characters</p>
                </div>

                <!-- Destination Section -->
                <div>
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-700 mb-2">Send Order To</label>
                    <div class="relative">
                        <select 
                            wire:model="destination" 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-slate-900 bg-white shadow-sm appearance-none">
                            <option value="" disabled class="text-slate-500">Select destination</option>
                            @forelse($suppliers as $supplier)
                                <option value="{{ $supplier->name }}">{{ $supplier->name }}</option>
                            @empty
                                <option value="" disabled>No suppliers available</option>
                            @endforelse
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Estimated delivery: 3-5 business days</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row md:items-center justify-between">
         <button 
            type="button" 
            onclick="history.back()" 
            class="px-6 py-2.5 border border-slate-300 rounded-lg font-semibold text-slate-700 hover:bg-slate-100 transition">
            Cancel
        </button>
        
        <button 
            wire:click="save" 
            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-bold uppercase tracking-wide hover:bg-blue-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Send Optical Order
        </button>
    </div>
</div>