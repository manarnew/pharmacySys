<div x-data="{ activeTab: @entangle('activeTab') }" class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">{{ __('Inventory & Stock Tracking') }}</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">{{ __('Monitor batch levels, expiries, and all stock movements.') }}</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 overflow-x-auto">
        <nav class="-mb-px flex space-x-4 sm:space-x-8" aria-label="Tabs">
            <button @click="activeTab = 'stock'; setTimeout(() => { $('#stockTable').DataTable().columns.adjust(); }, 50)" 
                :class="activeTab === 'stock' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm">
                {{ __('Current Stock') }}
            </button>
            <button @click="activeTab = 'movements'; setTimeout(() => { $('#movementsTable').DataTable().columns.adjust(); }, 50)" 
                :class="activeTab === 'movements' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm">
                {{ __('Movements Log') }}
            </button>
        </nav>
    </div>

    <!-- Tab Contents -->
    <div x-show="activeTab === 'stock'" class="space-y-4">
        <!-- Stock Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-3 sm:p-4 md:p-6">
                <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                    <div class="inline-block min-w-full align-middle px-3 sm:px-4 md:px-6">
                        <table id="stockTable" class="display w-full" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Product') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Store') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Batch No') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Expiry') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Qty') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($stock as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-900 font-medium text-center">
                                {{ $item->product->name }} ({{ $item->product->sku }})
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-500 text-center">{{ $item->store->name }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500 text-center">{{ $item->batch_no }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500 text-center">{{ $item->expiry_date->format('Y-m-d') }}</td>
                            <td class="py-3 px-4 text-sm font-bold text-center {{ $item->quantity <= ($item->product->reorder_level ?? 0) ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $item->quantity }} {{ $item->product->unit }}
                            </td>
                            <td class="py-3 px-4 text-sm text-center">
                                @if($item->isExpired())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ __('Expired') }}</span>
                                @elseif($item->isExpiringSoon())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ __('Expiring Soon') }}</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ __('Good') }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="activeTab === 'movements'" class="space-y-4" style="display: none;">
        <!-- Movements Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-3 sm:p-4 md:p-6">
                <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                    <div class="inline-block min-w-full align-middle px-3 sm:px-4 md:px-6">
                        <table id="movementsTable" class="display w-full" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Timestamp') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Product') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Type') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('In') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Out') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Balance') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Notes') }}</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">{{ __('User') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($movements as $move)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-xs text-gray-500 text-center">{{ $move->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900 font-medium text-center">{{ $move->product->name }}</td>
                            <td class="py-3 px-4 text-sm capitalize text-center">
                                <span class="px-2 py-0.5 rounded text-xs {{ $move->type === 'purchase' ? 'bg-blue-50 text-blue-700' : ($move->type === 'sale' ? 'bg-purple-50 text-purple-700' : 'bg-gray-50 text-gray-700') }}">
                                    {{ $move->type }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-green-600 font-bold text-center">{{ $move->quantity_in > 0 ? '+'.$move->quantity_in : '-' }}</td>
                            <td class="py-3 px-4 text-sm text-red-600 font-bold text-center">{{ $move->quantity_out > 0 ? '-'.$move->quantity_out : '-' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900 font-semibold text-center">{{ $move->balance }}</td>
                            <td class="py-3 px-4 text-xs text-gray-500 text-center">{{ $move->notes }}</td>
                            <td class="py-3 px-4 text-xs text-gray-500 text-center">{{ $move->creator->name ?? 'System' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function initDataTables() {
            if ($.fn.DataTable.isDataTable('#stockTable')) { $('#stockTable').DataTable().destroy(); }
            if ($.fn.DataTable.isDataTable('#movementsTable')) { $('#movementsTable').DataTable().destroy(); }
            
            const options = {
                pageLength: 25,
                lengthChange: true,
                ordering: true,
                responsive: false,
                scrollX: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '📥 {{ __('Export Excel') }}',
                    className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 border-none text-xs sm:text-sm mr-2'
                }],
                language: {
                    search: "",
                    searchPlaceholder: "{{ __('Search inventory...') }}",
                    emptyTable: "{{ __('No data available') }}"
                },
                initComplete: function() {
                    $('.dataTables_filter input').attr('placeholder', '{{ __('Search inventory...') }}');
                }
            };

            $('#stockTable').DataTable(options);
            $('#movementsTable').DataTable(options);
        }

        document.addEventListener('livewire:navigated', initDataTables);
        document.addEventListener('livewire:initialized', initDataTables);
        
        window.addEventListener('resize', () => {
            $('.dataTable').each(function() {
                if ($.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable().columns.adjust();
                }
            });
        });

        // Ensure alignment after any Livewire update
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('commit', ({ succeed }) => {
                succeed(() => {
                    setTimeout(() => {
                        $('.dataTable').each(function() {
                            if ($.fn.DataTable.isDataTable(this)) {
                                $(this).DataTable().columns.adjust(true);
                            }
                        });
                    }, 150);
                });
            });
        });
    </script>
</div>
