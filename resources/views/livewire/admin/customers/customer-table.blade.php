<div x-data="{ showModal: false, isEditing: @entangle('isEditing'), showConfirmDuplicate: @entangle('showConfirmDuplicate') }"
     @customer-saved.window="showModal = false; $wire.$refresh()"
     @open-edit-modal.window="showModal = true"
     class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Customers</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your customers and their records.</p>
        </div>
        <div class="flex items-center space-x-3">
            @can('create_customer')
            <form action="{{ route('admin.customers.import') }}" method="POST" enctype="multipart/form-data" class="inline-flex">
                @csrf
                <input type="file" name="file" id="excel_file" class="hidden" onchange="this.form.submit()" accept=".xlsx,.xls">
                <button type="button" onclick="document.getElementById('excel_file').click()" class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 mr-3">
                    <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Upload Excel
                </button>
            </form>
            <button @click="showModal = true; $wire.openModal()" type="button" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Customer
            </button>
            @endcan
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6">
            <table id="customersTable" class="display w-full" style="width:100%">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Name</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Age</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Phone</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($customers as $customer)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm font-medium">
                                <a href="{{ route('admin.customers.show', ['customer_id' => $customer->id]) }}" 
                                   wire:navigate
                                   class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                    {{ $customer->name }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $customer->age ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $customer->phone ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $customer->date ?? '-' }}</td>
                            <td class="py-3 px-4 text-right text-sm font-medium">
                                @can('create_examination')
                                <a href="{{ route('admin.examinations.index', ['customer_id' => $customer->id]) }}" class="text-green-600 hover:text-green-900 mr-3 transition-colors">Start Exam</a>
                                @endcan
                                
                                @can('edit_customer')
                                <button wire:click="edit({{ $customer->id }})" class="text-blue-600 hover:text-blue-900 mr-3 transition-colors">Edit</button>
                                @endcan

                                @can('delete_customer')
                                <button wire:click="delete({{ $customer->id }})" wire:confirm="Are you sure you want to delete this customer?" class="text-red-600 hover:text-red-900 transition-colors">Delete</button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background Overlay -->
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                <span x-text="isEditing ? 'Edit Customer' : 'Add New Customer'"></span>
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                <div class="grid grid-cols-1 gap-y-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                                        <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300 p-2 border">
                                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                                            <input type="number" wire:model="age" id="age" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300 p-2 border">
                                            @error('age') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                            <input type="text" wire:model="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border-gray-300 p-2 border">
                                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button x-on:click="isEditing ? $wire.update() : $wire.checkDuplicate()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Duplicate Confirmation Modal -->
    <div x-show="showConfirmDuplicate" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showConfirmDuplicate" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showConfirmDuplicate" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Duplicate Customer Detected</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">There is already a customer with the same name and phone number. Do you want to continue and save a duplicate record?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Yes, Save Duplicate
                    </button>
                    <button @click="showConfirmDuplicate = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        No, Skip
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#customersTable')) {
                $('#customersTable').DataTable().destroy();
            }
            
            $('#customersTable').DataTable({
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '📥 Export Excel',
                    className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 border-none'
                }],
                language: {
                    search: "Search customers:",
                    emptyTable: "No customers found",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        }

        document.addEventListener('livewire:navigated', initDataTable);
        
        document.addEventListener('livewire:initialized', () => {
            @foreach(['customer-saved', 'customer-deleted'] as $event)
                Livewire.on('{{ $event }}', () => {
                    setTimeout(initDataTable, 100);
                });
            @endforeach
        });
    </script>
</div>
