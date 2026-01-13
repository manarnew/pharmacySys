<div x-data="{ }" 
     @order-deleted.window="$wire.$refresh()"
     class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Orders</h1>
            <p class="mt-1 text-sm text-slate-500">Manage your orders and billing.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.orders.create') }}" wire:navigate class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Order
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6">
            <table id="ordersTable" class="display w-full" style="width:100%">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Invoice No</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Patient</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Total</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($orders as $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-slate-900 font-medium">{{ $order->invoice_no }}</td>
                            <td class="py-3 px-4 text-sm text-slate-900">
                                <a href="{{ route('admin.patients.show', ['patient_id' => $order->patient_id]) }}" wire:navigate class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                                    {{ $order->patient->name ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-sm text-slate-500">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-4 text-sm text-slate-900 font-bold">{{ number_format($order->total_amount, 2) }}</td>
                            <td class="py-3 px-4 text-sm">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium uppercase tracking-wider
                                    {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right text-sm font-medium">
                                <a href="{{ route('admin.orders.show', ['order_id' => $order->id]) }}" wire:navigate class="text-blue-600 hover:text-blue-900 mr-3 transition-colors">View</a>
                                
                                @can('delete_order')
                                <button wire:click="delete({{ $order->id }})" wire:confirm="Are you sure you want to delete this order?" class="text-red-600 hover:text-red-900 transition-colors">Delete</button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function initOrdersDataTable() {
            if ($.fn.DataTable.isDataTable('#ordersTable')) {
                $('#ordersTable').DataTable().destroy();
            }
            
            $('#ordersTable').DataTable({
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                order: [[2, 'desc']], // Default sort by date
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '📥 Export Excel',
                    className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 border-none'
                }],
                language: {
                    search: "Search orders:",
                    emptyTable: "No orders found",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        }

        document.addEventListener('livewire:navigated', initOrdersDataTable);
        
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('order-deleted', () => {
                setTimeout(initOrdersDataTable, 100);
            });
        });
    </script>
</div>
