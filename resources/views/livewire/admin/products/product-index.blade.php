<div x-data="{ showModal: false, isEditing: @entangle('isEditing') }"
     x-init="$watch('showModal', value => { if (!value) setTimeout(initDataTable, 100) })"
     @product-saved.window="showModal = false; $wire.$refresh()"
     @open-edit-modal.window="showModal = true"
     class="space-y-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">{{ __('Products') }}</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">{{ __('Manage your pharmacy products and medicines.') }}</p>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-3 sm:p-4 md:p-6">
            <!-- Add Button inside table container -->
            <div class="flex justify-end mb-4">
                @can('create_product')
                <button @click="showModal = true; $wire.openModal()" type="button" class="inline-flex items-center rounded-lg bg-blue-600 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                    <svg class="mr-1 sm:mr-2 -ml-1 h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="hidden sm:inline">{{ __('Add Product') }}</span>
                    <span class="sm:hidden">{{ __('Add') }}</span>
                </button>
                @endcan
            </div>
            <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                <div class="inline-block min-w-full align-middle px-3 sm:px-4 md:px-6">
                    <table id="productsTable" class="display w-full" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('SKU') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Name') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Category') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Price') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Status') }}</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-500 font-medium">{{ $product->sku }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900">
                                <div>{{ $product->name }}</div>
                                <div class="text-xs text-gray-400">{{ $product->generic_name }}</div>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900">
                                <div class="font-semibold">{{ __('Sell:') }} {{ number_format($product->selling_price, 2) }}</div>
                                <div class="text-xs text-gray-400">{{ __('Buy:') }} {{ number_format($product->purchase_price, 2) }}</div>
                            </td>
                            <td class="py-3 px-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.products.show', ['product_id' => $product->id]) }}" 
                                       wire:navigate 
                                       class="p-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors" 
                                       title="View">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @can('edit_product')
                                    <button wire:click="edit({{ $product->id }})" 
                                            class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" 
                                            title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    @endcan
                                    @can('delete_product')
                                    <button wire:click="delete({{ $product->id }})" 
                                            wire:confirm="Are you sure?" 
                                            class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" 
                                            title="Delete">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" x-transition.opacity @click="showModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full sm:my-8 sm:align-middle sm:max-w-2xl">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $isEditing ? __('Edit Product') : __('Add New Product') }}
                            </h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('SKU/Barcode') }}</label>
                                    <input type="text" wire:model="sku" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Product Name') }}</label>
                                    <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Generic Name') }}</label>
                                    <input type="text" wire:model="generic_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('generic_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                                    <select wire:model="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                        <option value="">{{ __('Select Category...') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Unit') }}</label>
                                    <select wire:model="unit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                        <option value="piece">{{ __('Piece') }}</option>
                                        <option value="box">{{ __('Box') }}</option>
                                        <option value="strip">{{ __('Strip') }}</option>
                                        <option value="bottle">{{ __('Bottle') }}</option>
                                        <option value="tube">{{ __('Tube') }}</option>
                                    </select>
                                    @error('unit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Purchase Price') }}</label>
                                    <input type="number" step="0.01" wire:model="purchase_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('purchase_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Selling Price') }}</label>
                                    <input type="number" step="0.01" wire:model="selling_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('selling_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Tax Rate (%)') }}</label>
                                    <input type="number" step="0.1" wire:model="tax_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('tax_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Reorder Level') }}</label>
                                    <input type="number" wire:model="reorder_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('reorder_level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                    <select wire:model="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                        <option value="active">{{ __('Active') }}</option>
                                        <option value="inactive">{{ __('Inactive') }}</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model="is_prescription_required" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">{{ __('Prescription Required') }}</span>
                                    </label>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                                    <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"></textarea>
                                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button x-on:click="isEditing ? $wire.update() : $wire.store()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Save') }}
                    </button>
                    <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#productsTable')) {
                $('#productsTable').DataTable().destroy();
            }
            
            $('#productsTable').DataTable({
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                responsive: true,
                scrollX: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '📥 {{ __('Export Excel') }}',
                    className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 border-none'
                }],
                language: {
                    search: "",
                    searchPlaceholder: "{{ __('Search products...') }}",
                    emptyTable: "{{ __('No products found') }}",
                    paginate: {
                        first: "{{ __('First') }}",
                        last: "{{ __('Last') }}",
                        next: "{{ __('Next') }}",
                        previous: "{{ __('Previous') }}"
                    }
                },
                initComplete: function() {
                    $('.dataTables_filter input').attr('placeholder', '{{ __('Search products...') }}');
                }
            });
        }

        document.addEventListener('livewire:navigated', initDataTable);
        
        document.addEventListener('livewire:initialized', () => {
            @foreach(['product-saved', 'product-deleted', 'open-edit-modal'] as $event)
                Livewire.on('{{ $event }}', () => {
                    setTimeout(initDataTable, 100);
                });
            @endforeach
        });


    </script>
</div>
