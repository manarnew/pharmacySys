<div x-data="{ showModal: @entangle('showCreateModal') }"
     x-init="$watch('showModal', value => { if (!value) setTimeout(initDataTable, 100) })"
     @sale-saved.window="showModal = false; $wire.$refresh()"
     class="space-y-6">
    
    <!-- Header -->
    <div class="mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">{{ __('Sales') }}</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">{{ __('Manage customer sales and inventory deduction.') }}</p>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-3 sm:p-4 md:p-6">
            <!-- Add Button inside table container -->
            <div class="flex justify-end mb-4">
                @can('create_sale')
                <a href="{{ route('admin.sales.create') }}" wire:navigate class="inline-flex items-center rounded-lg bg-blue-600 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                    <svg class="mr-1 sm:mr-2 -ml-1 h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="hidden sm:inline">{{ __('New Sale') }}</span>
                    <span class="sm:hidden">{{ __('New') }}</span>
                </a>
                @endcan
            </div>
            <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                <div class="inline-block min-w-full align-middle px-3 sm:px-4 md:px-6">
                    <table id="salesTable" class="display w-full" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Date') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Invoice No') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Customer') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Type') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Total') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Paid') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Status') }}</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($sales as $sale)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $sale->sale_date->format('Y-m-d') }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                <a href="{{ route('admin.sales.print', $sale) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1 group">
                                    <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    {{ $sale->invoice_no }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $sale->customer->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                    @if($sale->payment_type === 'bankak') bg-purple-100 text-purple-800 
                                    @elseif($sale->payment_type === 'cash_bankak') bg-blue-100 text-blue-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ __($sale->payment_type === 'cash_bankak' ? 'Cash & Bankak' : ($sale->payment_type === 'bankak' ? 'Bankak' : 'Cash')) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-900 font-bold">{{ number_format($sale->total, 2) }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900">{{ number_format($sale->paid_amount, 2) }}</td>
                            <td class="py-3 px-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $sale->payment_status === 'paid' ? 'bg-green-100 text-green-800' : ($sale->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($sale->payment_status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.sales.return', ['sale_id' => $sale->id]) }}" 
                                       wire:navigate 
                                       class="p-2 text-orange-600 hover:text-orange-700 hover:bg-orange-50 rounded-lg transition-colors" 
                                       title="{{ __('Return') }}">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                        </svg>
                                    </a>
                                    @can('delete_sale')
                                    <button wire:click="delete({{ $sale->id }})" 
                                            wire:confirm="{{ __('Are you sure? This will restore the stock.') }}" 
                                            class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" 
                                            title="{{ __('Delete') }}">
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

    <script>
        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#salesTable')) {
                $('#salesTable').DataTable().destroy();
            }
            
            $('#salesTable').DataTable({
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
                    searchPlaceholder: "{{ __('Search sales...') }}",
                    emptyTable: "{{ __('No sales found') }}",
                    paginate: {
                        first: "{{ __('First') }}",
                        last: "{{ __('Last') }}",
                        next: "{{ __('Next') }}",
                        previous: "{{ __('Previous') }}"
                    }
                },
                initComplete: function() {
                    $('.dataTables_filter input').attr('placeholder', '{{ __('Search sales...') }}');
                }
            });
        }

        document.addEventListener('livewire:navigated', initDataTable);
        
        document.addEventListener('livewire:initialized', () => {
            @foreach(['sale-saved', 'sale-deleted', 'open-edit-modal'] as $event)
                Livewire.on('{{ $event }}', () => {
                    setTimeout(initDataTable, 100);
                });
            @endforeach
        });
    </script>
</div>
