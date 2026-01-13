<div class="max-w-6xl mx-auto p-4 space-y-6">
    
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
    
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">New Prescription</h1>
            <div class="flex items-center mt-2 space-x-2 text-sm text-slate-500">
                <span>Patient:</span>
                <span class="font-semibold text-slate-900">{{ $patient->name ?? 'N/A' }}</span>
                <span class="bg-blue-100 text-blue-700 py-0.5 px-2 rounded-full text-xs font-medium">#{{ $patient->id ?? '' }}</span>
            </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date Issued</p>
            <p class="text-lg font-bold text-slate-900">{{ now()->format('F d, Y') }}</p>
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
    
    <!-- Prescription Details -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center">
                 <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                 Prescription Values
            </h3>
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
                        <td class="p-3 border-r border-slate-200">
                            <div class="flex space-x-2">
                                <select wire:model="sphere_od" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                    <option value="">Select</option>
                                    <option value="PL">PL</option>
                                    @php $vals = range(0.25, 6.00, 0.25); @endphp
                                    @foreach($vals as $v) <option value="+{{number_format($v, 2)}}">+{{number_format($v, 2)}}</option> @endforeach
                                    @foreach($vals as $v) <option value="-{{number_format($v, 2)}}">-{{number_format($v, 2)}}</option> @endforeach
                                </select>
                                <input type="text" wire:model="sphere_od" placeholder="Custom" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center" />
                            </div>
                        </td>
                        <!-- CYL -->
                        <td class="p-3 border-r border-slate-200">
                            <div class="flex space-x-2">
                                <select wire:model="cyl_od" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                    <option value="">Select</option>
                                     @foreach($vals as $v) <option value="-{{number_format($v, 2)}}">-{{number_format($v, 2)}}</option> @endforeach
                                </select>
                                <input type="text" wire:model="cyl_od" placeholder="Custom" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center" />
                            </div>
                        </td>
                        <!-- AXIS -->
                         <td class="p-3 border-r border-slate-200">
                             <select wire:model="axis_od" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                <option value="">Select</option>
                                @for($i=5; $i<=180; $i+=5) <option value="{{$i}}">{{$i}}</option> @endfor
                            </select>
                        </td>
                         <!-- ADD -->
                         <td class="p-3 border-r border-slate-200">
                             <select wire:model="add_od" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                <option value="">Select</option>
                                <option value="PL">PL</option>
                                @php $adds = range(0.25, 4.00, 0.25); @endphp
                                @foreach($adds as $v) <option value="+{{number_format($v, 2)}}">+{{number_format($v, 2)}}</option> @endforeach
                            </select>
                        </td>
                         <!-- VA -->
                         <td class="p-3">
                             <select wire:model="va_od" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                <option value="">Select</option>
                                @foreach(['6/60','6/36','6/24','6/18','6/12','6/9','6/7.5','6/6','6/4','6/3','20/20','CF','HM','LP','NLP'] as $v) <option value="{{$v}}">{{$v}}</option> @endforeach
                            </select>
                        </td>
                    </tr>
                     <!-- OS Row -->
                     <tr>
                        <td class="px-4 py-3 text-center font-bold text-green-600 bg-green-50/50 border-r border-slate-200">OS</td>
                        <td class="p-3 border-r border-slate-200">
                            <div class="flex space-x-2">
                                <select wire:model="sphere_os" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                    <option value="">Select</option>
                                    <option value="PL">PL</option>
                                    @php $vals = range(0.25, 6.00, 0.25); @endphp
                                    @foreach($vals as $v) <option value="+{{number_format($v, 2)}}">+{{number_format($v, 2)}}</option> @endforeach
                                    @foreach($vals as $v) <option value="-{{number_format($v, 2)}}">-{{number_format($v, 2)}}</option> @endforeach
                                </select>
                                <input type="text" wire:model="sphere_os" placeholder="Custom" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center" />
                            </div>
                        </td>
                         <!-- CYL -->
                        <td class="p-3 border-r border-slate-200">
                            <div class="flex space-x-2">
                                <select wire:model="cyl_os" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                    <option value="">Select</option>
                                     @foreach($vals as $v) <option value="-{{number_format($v, 2)}}">-{{number_format($v, 2)}}</option> @endforeach
                                </select>
                                <input type="text" wire:model="cyl_os" placeholder="Custom" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center" />
                            </div>
                        </td>
                        <!-- AXIS -->
                         <td class="p-3 border-r border-slate-200">
                             <select wire:model="axis_os" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                <option value="">Select</option>
                                @for($i=5; $i<=180; $i+=5) <option value="{{$i}}">{{$i}}</option> @endfor
                            </select>
                        </td>
                         <!-- ADD -->
                         <td class="p-3 border-r border-slate-200">
                             <select wire:model="add_os" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                <option value="">Select</option>
                                <option value="PL">PL</option>
                                @php $adds = range(0.25, 4.00, 0.25); @endphp
                                @foreach($adds as $v) <option value="+{{number_format($v, 2)}}">+{{number_format($v, 2)}}</option> @endforeach
                            </select>
                        </td>
                         <!-- VA -->
                         <td class="p-3">
                             <select wire:model="va_os" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm text-center">
                                <option value="">Select</option>
                                @foreach(['6/60','6/36','6/24','6/18','6/12','6/9','6/7.5','6/6','6/4','6/3','20/20','CF','HM','LP','NLP'] as $v) <option value="{{$v}}">{{$v}}</option> @endforeach
                            </select>
                        </td>
                     </tr>
                </tbody>
             </table>
        </div>
    </div>
    
    <!-- Extra Fields (IPD, Notes) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- IPD -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
             <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4 flex items-center">
                 IPD Measurement
            </h3>
            <div class="flex items-center space-x-2">
                 <select wire:model="ipd" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select IPD</option>
                    @for ($i = 48; $i <= 75; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        
        <!-- Notes -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
              <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4 flex items-center">
                 Clinical Notes
            </h3>
            <textarea wire:model="notes" 
                class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-slate-400"
                placeholder="Enter clinical notes..."
                rows="3">
            </textarea>
        </div>
    </div>
    
    <!-- Specialist Info & Submit -->
     <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center space-x-3">
             <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
             </div>
             <div>
                <p class="text-sm font-medium text-slate-500">Prescribing Specialist</p>
                <p class="font-bold text-slate-900">{{ $prescription->specialist->name ?? auth()->user()->name }}</p>
             </div>
        </div>

        @can('create_prescription')
            <button wire:click="save" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Save Prescription
            </button>
        @else
            <p class="text-sm text-red-600 font-medium">You do not have permission to save prescriptions.</p>
        @endcan
     </div>
</div>