<div x-data="{ showModal: @entangle('showCreateModal') }"
     @purchase-saved.window="showModal = false; $wire.$refresh()"
     class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">Purchases</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">Manage supplier purchase orders and stock entry.</p>
        </div>
        <div class="flex items-center space-x-3">
            @can('create_purchase')
            <button @click="$wire.openModal()" type="button" class="inline-flex items-center rounded-lg bg-blue-600 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                <svg class="mr-1 sm:mr-2 -ml-1 h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="hidden sm:inline">New Purchase</span>
                <span class="sm:hidden">New</span>
            </button>
            @endcan
        </div>
    </div>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-3 sm:p-4 md:p-6">
            <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                <div class="inline-block min-w-full align-middle px-3 sm:px-4 md:px-6">
                    <table id="purchasesTable" class="display w-full" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Date</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Invoice No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Supplier</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Total</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Created By</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($purchases as $purchase)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $purchase->purchase_date->format('Y-m-d') }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900 font-medium">{{ $purchase->invoice_no }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $purchase->supplier->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900 font-bold">{{ number_format($purchase->total, 2) }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $purchase->creator->name ?? 'System' }}</td>
                            <td class="py-3 px-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.purchases.return', ['purchase_id' => $purchase->id]) }}" wire:navigate 
                                       class="inline-flex items-center rounded-lg bg-orange-50 px-3 py-1 text-xs font-bold text-orange-600 hover:bg-orange-100 transition-colors">
                                        Return
                                    </a>
                                    @can('delete_purchase')
                                    <button wire:click="delete({{ $purchase->id }})" wire:confirm="Are you sure? This will reverse the stock." 
                                            class="text-red-500 hover:text-red-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
    <div x-show="showModal" 
         x-init="$watch('showModal', value => { if(value) setTimeout(initSelect2, 100) })"
         class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
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
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full sm:my-8 sm:align-middle sm:max-w-6xl">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Record New Purchase</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Supplier</label>
                                    <div wire:ignore>
                                        <select id="supplier-select" class="mt-1 block w-full">
                                            @if($supplier_id)
                                                <option value="{{ $supplier_id }}" selected>{{ App\Models\Supplier::find($supplier_id)?->name }}</option>
                                            @else
                                                <option value="">Select Supplier</option>
                                            @endif
                                        </select>
                                    </div>
                                    @error('supplier_id') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Invoice No</label>
                                    <input type="text" wire:model="invoice_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('invoice_no') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Purchase Date</label>
                                    <input type="date" wire:model="purchase_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    @error('purchase_date') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-800 mb-2">Purchase Items</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Batch</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase w-20">Qty</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase w-32">Price</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($items as $index => $item)
                                            <tr wire:key="p-item-{{ $index }}">
                                                <td class="p-2" style="min-width: 200px;">
                                                    <div wire:ignore>
                                                        <select class="purchase-product-select block w-full" data-index="{{ $index }}">
                                                            @if($item['product_id'])
                                                                <option value="{{ $item['product_id'] }}" selected>{{ App\Models\Product::find($item['product_id'])?->name }}</option>
                                                            @else
                                                                <option value="">Search Product...</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('items.'.$index.'.product_id') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                                </td>
                                                <td class="p-2">
                                                    <select wire:model="items.{{ $index }}.store_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 sm:text-xs border p-1">
                                                        <option value="">Select Store</option>
                                                        @foreach($stores as $store)
                                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('items.'.$index.'.store_id') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                                </td>
                                                <td class="p-2">
                                                    <input type="text" wire:model="items.{{ $index }}.batch_no" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 sm:text-xs border p-1">
                                                    @error('items.'.$index.'.batch_no') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                                </td>
                                                <td class="p-2">
                                                    <input type="date" wire:model="items.{{ $index }}.expiry_date" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 sm:text-xs border p-1">
                                                    @error('items.'.$index.'.expiry_date') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                                </td>
                                                <td class="p-2">
                                                    <input type="number" wire:model.live.debounce.300ms="items.{{ $index }}.quantity" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 sm:text-xs border p-1">
                                                    @error('items.'.$index.'.quantity') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                                </td>
                                                <td class="p-2">
                                                    <input type="number" step="0.01" wire:model.live.debounce.300ms="items.{{ $index }}.unit_price" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 sm:text-xs border p-1">
                                                    @error('items.'.$index.'.unit_price') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                                </td>
                                                <td class="p-2 text-xs font-bold text-gray-700">
                                                    {{ number_format(($items[$index]['quantity'] ?? 0) * ($items[$index]['unit_price'] ?? 0), 2) }}
                                                </td>
                                                <td class="p-2 text-right">
                                                    <button type="button" wire:click="removeItem({{ $index }})" class="text-red-600 hover:text-red-900">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" class="p-2">
                                                    <button type="button" wire:click="addItem" class="inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-900">
                                                        <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                        Add Item
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="mt-4 flex flex-col items-end space-y-2">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-700">Discount:</span>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="discount" class="rounded-md border-gray-300 shadow-sm sm:text-xs border p-1 w-32">
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-700">Tax:</span>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="tax" class="rounded-md border-gray-300 shadow-sm sm:text-xs border p-1 w-32">
                                    </div>
                                    <div class="text-lg font-bold text-blue-600">
                                        Total: {{ number_format(collect($items)->sum(fn($i) => ($i['quantity'] ?? 0) * ($i['unit_price'] ?? 0)) - $discount + $tax, 2) }}
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea wire:model="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="store" wire:loading.attr="disabled" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                        <span wire:loading.remove>Confirm Purchase & Save Stock</span>
                        <span wire:loading>Saving...</span>
                    </button>
                    <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#purchasesTable')) {
                $('#purchasesTable').DataTable().destroy();
            }
            
            $('#purchasesTable').DataTable({
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                responsive: true,
                scrollX: true,
                dom: '<"flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4"Bf><"flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"lfr>t<"flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-4"ip>',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '📥 Export Excel',
                    className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 border-none text-xs sm:text-sm'
                }],
                language: {
                    search: "Search purchases:",
                    emptyTable: "No purchases found",
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
        
        document.addEventListener('livewire:init', () => {
            initSelect2();
            @this.on('item-added', () => setTimeout(initSelect2, 100));

            @foreach(['purchase-saved', 'purchase-deleted'] as $event)
                Livewire.on('{{ $event }}', () => {
                    setTimeout(initDataTable, 100);
                });
            @endforeach
        });

        function initSelect2() {
            const dropdownParent = $('#modal-title').closest('.inline-block');
            
            $('#supplier-select').select2({
                placeholder: 'Search supplier...',
                dropdownParent: dropdownParent,
                ajax: {
                    url: '{{ route("admin.search.suppliers") }}',
                    dataType: 'json',
                    delay: 250,
                    data: (params) => ({ q: params.term }),
                    processResults: (data) => ({ results: data })
                }
            }).on('change', function (e) {
                @this.set('supplier_id', $(this).val());
            });

            $('.purchase-product-select').each(function() {
                let index = $(this).data('index');
                $(this).select2({
                    placeholder: 'Search product...',
                    dropdownParent: dropdownParent,
                    ajax: {
                        url: '{{ route("admin.search.products") }}',
                        dataType: 'json',
                        delay: 250,
                        data: (params) => ({ q: params.term }),
                        processResults: (data) => ({ results: data })
                    }
                }).on('change', function (e) {
                    @this.setProduct(index, $(this).val());
                });
            });
        }
    </script>
</div>
