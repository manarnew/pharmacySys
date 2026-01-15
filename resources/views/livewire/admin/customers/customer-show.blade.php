<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <!-- Customer Info -->
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Customer Information</h2>
                        <div class="h-px flex-grow ml-4 bg-gradient-to-r from-blue-400 to-blue-100"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-blue-200 transition">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-semibold">👤</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-700">Name</span>
                                    <span class="text-lg font-medium text-gray-900">{{ $customer->name }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-blue-200 transition">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <span class="text-green-600 font-semibold">🎂</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-700">Age</span>
                                    <span class="text-lg font-medium text-gray-900">{{ $customer->age ? $customer->age . ' years' : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-blue-200 transition">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <span class="text-purple-600 font-semibold">📞</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-700">Contact</span>
                                    <span class="text-lg font-medium text-gray-900">{{ $customer->phone ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-blue-200 transition">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                    <span class="text-yellow-600 font-semibold">📅</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-700">Last Purchase</span>
                                    <span class="text-lg font-medium text-gray-900">{{ $customer->sales->first()?->sale_date->format('Y-m-d') ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase History -->
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Purchase History</h2>
                        <div class="h-px flex-grow ml-4 bg-gradient-to-r from-green-400 to-green-100"></div>
                    </div>
                    
                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                        Invoice #
                                    </th>
                                    <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($customer->sales as $sale)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center mr-4">
                                                <span class="text-blue-600 font-bold">{{ $sale->sale_date->format('d') }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $sale->sale_date->format('Y-m-d') }}</div>
                                                <div class="text-xs text-gray-500">{{ $sale->sale_date->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                         <span class="text-sm font-bold text-gray-900">#{{ $sale->invoice_no }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sale->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($sale->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap font-bold text-blue-600">
                                        ${{ number_format($sale->total, 2) }}
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.sales.create') }}?sale_id={{ $sale->id }}" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium text-xs uppercase tracking-wider">
                                                <span class="mr-2 text-sm">👁️</span>
                                                View
                                            </a>
                                            <a href="{{ route('admin.invoices.print', ['sale_id' => $sale->id]) }}" 
                                               target="_blank"
                                               class="inline-flex items-center px-4 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium text-xs uppercase tracking-wider">
                                                <span class="mr-2 text-sm">🖨️</span>
                                                Print
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-gray-500 italic">
                                        No purchase history found for this customer.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>