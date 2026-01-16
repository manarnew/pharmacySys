<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">New Sale</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">Create a new customer invoice and deduct stock.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.sales.index') }}" wire:navigate class="inline-flex items-center rounded-lg bg-gray-100 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none transition-all duration-200">
                <span class="hidden sm:inline">Back to List</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 md:p-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Sale Items</h3>
                <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                    <div class="inline-block min-w-full align-middle px-3 sm:px-4 md:px-6">
                        <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-3 py-3 text-left">Product</th>
                                <th class="px-3 py-3 text-left">Store</th>
                                <th class="px-3 py-3 text-left w-24">Qty</th>
                                <th class="px-3 py-3 text-left w-32">Price</th>
                                <th class="px-3 py-3 text-left">Total</th>
                                <th class="px-3 py-3 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $index => $item)
                            <tr wire:key="item-{{ $index }}">
                                <td class="px-3 py-4" style="min-width: 250px;">
                                    <div wire:ignore>
                                        <select id="product-select-{{ $index }}" class="product-select w-full" data-index="{{ $index }}">
                                            @if($item['product_id'])
                                                <option value="{{ $item['product_id'] }}" selected>{{ $item['product_name'] }}</option>
                                            @else
                                                <option value="">Search Product...</option>
                                            @endif
                                        </select>
                                    </div>
                                    @error('items.'.$index.'.product_id') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </td>
                                <td class="px-3 py-4">
                                    <select wire:model="items.{{ $index }}.store_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2">
                                        <option value="">Store</option>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('items.'.$index.'.store_id') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </td>
                                <td class="px-3 py-4">
                                    <input type="number" wire:model.live.debounce.300ms="items.{{ $index }}.quantity" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2 text-center">
                                    @error('items.'.$index.'.quantity') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </td>
                                <td class="px-3 py-4">
                                    <input type="number" step="0.01" wire:model.live.debounce.300ms="items.{{ $index }}.unit_price" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2 text-right">
                                    @error('items.'.$index.'.unit_price') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </td>
                                <td class="px-3 py-4 text-sm font-bold text-gray-700 text-right">
                                    {{ number_format(($items[$index]['quantity'] ?? 0) * ($items[$index]['unit_price'] ?? 0), 2) }}
                                </td>
                                <td class="px-3 py-4 text-right">
                                    <button type="button" wire:click="removeItem({{ $index }})" class="text-red-400 hover:text-red-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <button type="button" wire:click="addItem" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Another Item
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 md:p-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Additional Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Invoice Notes</label>
                        <textarea wire:model="notes" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2" placeholder="Internal notes or customer messages..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Total Summary -->
        <div class="space-y-4 sm:space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 md:p-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Sale Summary</h3>
                <div class="space-y-4">
                    <div wire:ignore>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                        <select id="customer-select" class="w-full">
                            @if($customer_id)
                                <option value="{{ $customer_id }}" selected>{{ App\Models\Customer::find($customer_id)?->name }}</option>
                            @else
                                <option value="">Search Customer...</option>
                            @endif
                        </select>
                    </div>
                    @error('customer_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" wire:model="sale_date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Invoice #</label>
                            <div class="flex space-x-1">
                                <input type="text" wire:model="invoice_no" class="block w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:ring-blue-500 sm:text-sm border p-2" readonly>
                                <button type="button" wire:click="regenerateInvoiceNo" class="p-2 text-gray-500 hover:text-blue-600 bg-gray-50 border border-gray-300 rounded-lg flex-shrink-0" title="Regenerate Invoice Number">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </button>
                            </div>
                            @error('invoice_no') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Type</label>
                        <select wire:model="payment_type" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2">
                            <option value="cash">Cash</option>
                            <option value="bankak">Bankak</option>
                        </select>
                    </div>

                    <hr class="my-4 border-gray-100">

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium font-mono">${{ number_format(collect($items)->sum(fn($i) => ($i['quantity'] ?? 0) * ($i['unit_price'] ?? 0)), 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Discount</span>
                            <input type="number" wire:model.live.debounce.300ms="discount" class="w-24 rounded-lg border-gray-300 border p-1 text-right text-sm">
                        </div>
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Tax</span>
                            <input type="number" wire:model.live.debounce.300ms="tax" class="w-24 rounded-lg border-gray-300 border p-1 text-right text-sm">
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <span class="text-xl font-black text-blue-600 font-mono">
                                ${{ number_format(max(0, collect($items)->sum(fn($i) => ($i['quantity'] ?? 0) * ($i['unit_price'] ?? 0)) - $discount + $tax), 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <label class="block text-sm font-bold text-blue-800 mb-1 uppercase tracking-wider">Paid Amount</label>
                            <input type="number" step="0.01" wire:model.live.debounce.300ms="paid_amount" class="block w-full rounded-lg border-blue-300 shadow-sm focus:ring-blue-500 text-lg font-bold border p-2 text-right">
                            <div class="mt-2 flex justify-between text-xs font-medium">
                                <span class="text-blue-600">Balance Due:</span>
                                <span class="text-red-600 font-mono">${{ number_format(max(0, (collect($items)->sum(fn($i) => ($i['quantity'] ?? 0) * ($i['unit_price'] ?? 0)) - $discount + $tax) - $paid_amount), 2) }}</span>
                            </div>
                        </div>
                        <button wire:click="store" wire:loading.attr="disabled" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all flex items-center justify-center space-x-2 disabled:opacity-50">
                            <span wire:loading.remove>Save Sale & Print</span>
                            <span wire:loading>Processing...</span>
                            <svg wire:loading.remove class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('item-added', () => {
            setTimeout(initSelect2, 100);
        });

        $wire.on('sale-completed', (event) => {
            // Handle both object and named param array formats (LW3 variation)
            const saleId = event.saleId || (Array.isArray(event) ? event[0].saleId : null);
            if (saleId) {
                const printUrl = "{{ route('admin.sales.print', ':id') }}".replace(':id', saleId);
                window.open(printUrl, '_blank');
            }
        });

        $wire.on('form-reset', () => {
            setTimeout(() => {
                initSelect2();
                // Clear search values in Select2
                $('#customer-select').val('').trigger('change.select2');
                $('.product-select').each(function() {
                    $(this).val('').trigger('change.select2');
                });
                
                // Re-set the default customer if Livewire has it
                const customerId = $wire.customer_id;
                if (customerId) {
                    $('#customer-select').val(customerId).trigger('change');
                }
            }, 100);
        });

        // Initialize on load
        initSelect2();

        function initSelect2() {
            // Customer Search
            $('#customer-select').select2({
                placeholder: 'Search for customer...',
                ajax: {
                    url: '{{ route("admin.search.customers") }}',
                    dataType: 'json',
                    delay: 250,
                    data: (params) => ({ q: params.term }),
                    processResults: (data) => ({ results: data })
                }
            }).on('change', function (e) {
                $wire.setCustomer($(this).val());
            });

            // Trigger change for initial value (default customer)
            if($('#customer-select').val()) {
                $wire.setCustomer($('#customer-select').val());
            }

            // Product Search per row
            $('.product-select').each(function() {
                let index = $(this).data('index');
                $(this).select2({
                    placeholder: 'Search for product...',
                    ajax: {
                        url: '{{ route("admin.search.products") }}',
                        dataType: 'json',
                        delay: 250,
                        data: (params) => ({ q: params.term }),
                        processResults: (data) => ({ results: data })
                    }
                }).on('change', function (e) {
                    let data = $(this).select2('data')[0];
                    if (data) {
                        $wire.setProduct(index, data.id, data.price);
                    }
                });
            });
        }
    </script>
    @endscript
</div>
