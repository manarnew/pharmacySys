<div class="max-w-6xl mx-auto p-4 space-y-6">
    
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">New Examination</h1>
            <div class="flex items-center mt-2 space-x-2 text-sm text-slate-500">
                <span>Patient:</span>
                <span class="font-semibold text-slate-900">{{ $patient->name }}</span>
                <span class="bg-blue-100 text-blue-700 py-0.5 px-2 rounded-full text-xs font-medium">#{{ $patient->id }}</span>
            </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</p>
            <p class="text-lg font-bold text-slate-900">{{ now()->format('F d, Y') }}</p>
        </div>
    </div>

    <!-- Patient Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
         <!-- Age -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center space-x-4">
            <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Age</p>
                <p class="text-xl font-bold text-slate-900">{{ $patient->age ?? '-' }} <span class="text-sm font-normal text-slate-400">years</span></p>
            </div>
        </div>
        
        <!-- Phone -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center space-x-4">
            <div class="p-3 bg-green-50 rounded-lg text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </div>
             <div>
                <p class="text-sm font-medium text-slate-500">Phone</p>
                <p class="text-xl font-bold text-slate-900">{{ $patient->phone ?? '-' }}</p>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save" class="space-y-8">
        <!-- Medical History -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Medical History
            </h2>
             <textarea 
                wire:model="history"
                id="history" 
                rows="3"
                class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder:text-slate-400 text-sm"
                placeholder="Enter patient medical history..."
            ></textarea>
        </div>

        <!-- Old RX Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
             <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Previous Prescription (Old RX)</h3>
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
                                     <select wire:model="old_sphere_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select</option>
                                        <option value="PL">PL</option>
                                        @foreach(['+0.25','+0.50','+0.75','+1.00','+1.25','+1.50','-0.25','-0.50','-1.00','-1.50','-2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                    </select>
                                    <input type="text" wire:model="old_sphere_od" placeholder="Custom" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                            </td>
                            <td class="p-3 border-r border-slate-200">
                                <div class="flex space-x-2">
                                    <select wire:model="old_cyl_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select</option>
                                        @foreach(['-0.25','-0.50','-0.75','-1.00','-1.25','-1.50','-2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                    </select>
                                    <input type="text" wire:model="old_cyl_od" placeholder="Custom" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                            </td>
                            <td class="p-3 border-r border-slate-200">
                                 <select wire:model="old_axis_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    @foreach(['5','10','15','45','90','135','180'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                             <td class="p-3 border-r border-slate-200">
                                 <select wire:model="old_add_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    <option value="PL">PL</option>
                                    @foreach(['+0.25','+0.50','+1.00','+1.50','+2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                             <td class="p-3">
                                 <select wire:model="old_va_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    @foreach(['6/60','6/36','6/24','6/18','6/12','6/9','6/6','20/20','CF','HM','LP','NLP'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                         </tr>
                         <!-- OS -->
                         <tr>
                            <td class="px-4 py-3 text-center font-bold text-green-600 bg-green-50/50 border-r border-slate-200">OS</td>
                             <td class="p-3 border-r border-slate-200">
                                <div class="flex space-x-2">
                                     <select wire:model="old_sphere_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select</option>
                                        <option value="PL">PL</option>
                                        @foreach(['+0.25','+0.50','+0.75','+1.00','+1.25','+1.50','-0.25','-0.50','-1.00','-1.50','-2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                    </select>
                                    <input type="text" wire:model="old_sphere_os" placeholder="Custom" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                            </td>
                            <td class="p-3 border-r border-slate-200">
                                <div class="flex space-x-2">
                                    <select wire:model="old_cyl_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select</option>
                                        @foreach(['-0.25','-0.50','-0.75','-1.00','-1.25','-1.50','-2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                    </select>
                                    <input type="text" wire:model="old_cyl_os" placeholder="Custom" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                            </td>
                            <td class="p-3 border-r border-slate-200">
                                 <select wire:model="old_axis_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    @foreach(['5','10','15','45','90','135','180'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                             <td class="p-3 border-r border-slate-200">
                                 <select wire:model="old_add_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    <option value="PL">PL</option>
                                    @foreach(['+0.25','+0.50','+1.00','+1.50','+2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                             <td class="p-3">
                                 <select wire:model="old_va_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    @foreach(['6/60','6/36','6/24','6/18','6/12','6/9','6/6','20/20','CF','HM','LP','NLP'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                         </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Subjective Refraction -->
         <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
             <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Subjective Refraction</h3>
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
                                     <select wire:model="subj_sphere_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select</option>
                                        <option value="PL">PL</option>
                                        @foreach(['+0.25','+0.50','+0.75','+1.00','+1.25','+1.50','-0.25','-0.50','-1.00','-1.50','-2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                    </select>
                                    <input type="text" wire:model="subj_sphere_od" placeholder="Custom" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                            </td>
                            <td class="p-3 border-r border-slate-200">
                                <div class="flex space-x-2">
                                    <select wire:model="subj_cyl_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select</option>
                                        @foreach(['-0.25','-0.50','-0.75','-1.00','-1.25','-1.50','-2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                    </select>
                                    <input type="text" wire:model="subj_cyl_od" placeholder="Custom" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                            </td>
                            <td class="p-3 border-r border-slate-200">
                                 <select wire:model="subj_axis_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    @foreach(['5','10','15','45','90','135','180'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                             <td class="p-3 border-r border-slate-200">
                                 <select wire:model="subj_add_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    <option value="PL">PL</option>
                                    @foreach(['+0.25','+0.50','+1.00','+1.50','+2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                             <td class="p-3">
                                 <select wire:model="subj_va_od" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    @foreach(['6/60','6/36','6/24','6/18','6/12','6/9','6/6','20/20','CF','HM','LP','NLP'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                         </tr>
                         <!-- OS -->
                         <tr>
                            <td class="px-4 py-3 text-center font-bold text-green-600 bg-green-50/50 border-r border-slate-200">OS</td>
                             <td class="p-3 border-r border-slate-200">
                                <div class="flex space-x-2">
                                     <select wire:model="subj_sphere_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select</option>
                                        <option value="PL">PL</option>
                                        @foreach(['+0.25','+0.50','+0.75','+1.00','+1.25','+1.50','-0.25','-0.50','-1.00','-1.50','-2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                    </select>
                                    <input type="text" wire:model="subj_sphere_os" placeholder="Custom" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                            </td>
                            <td class="p-3 border-r border-slate-200">
                                <div class="flex space-x-2">
                                    <select wire:model="subj_cyl_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select</option>
                                        @foreach(['-0.25','-0.50','-0.75','-1.00','-1.25','-1.50','-2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                    </select>
                                    <input type="text" wire:model="subj_cyl_os" placeholder="Custom" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                            </td>
                            <td class="p-3 border-r border-slate-200">
                                 <select wire:model="subj_axis_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    @foreach(['5','10','15','45','90','135','180'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                             <td class="p-3 border-r border-slate-200">
                                 <select wire:model="subj_add_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    <option value="PL">PL</option>
                                    @foreach(['+0.25','+0.50','+1.00','+1.50','+2.00'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                             <td class="p-3">
                                 <select wire:model="subj_va_os" class="w-full rounded-md border-slate-200 text-xs py-1.5 text-center text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    @foreach(['6/60','6/36','6/24','6/18','6/12','6/9','6/6','20/20','CF','HM','LP','NLP'] as $val) <option value="{{$val}}">{{$val}}</option> @endforeach
                                </select>
                            </td>
                         </tr>
                    </tbody>
                </table>
            </div>
         </div>
         
         <!-- Specialist Info & Submit -->
         <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center space-x-3">
                 <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                 </div>
                 <div>
                    <p class="text-sm font-medium text-slate-500">Examining Specialist</p>
                    <p class="font-bold text-slate-900">{{ auth()->user()->name }}</p>
                 </div>
            </div>

            @can('create_examination')
                <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Save Examination
                </button>
            @else
                <p class="text-sm text-red-600 font-medium">You do not have permission to save examinations.</p>
            @endcan
         </div>
    </form>
</div>