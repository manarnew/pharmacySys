<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.products.index') }}" wire:navigate class="p-2 bg-white rounded-full shadow-sm hover:shadow-md transition border border-gray-100 group">
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">{{ $product->name }}</h1>
                    <div class="flex items-center mt-1 space-x-2">
                        <span class="text-sm font-medium text-gray-500">SKU: {{ $product->sku }}</span>
                        <span class="h-1 w-1 bg-gray-300 rounded-full"></span>
                        <span class="text-sm font-medium text-blue-600">{{ $product->category->name ?? 'Uncategorized' }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    ● {{ ucfirst($product->status) }}
                </span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Current Stock</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-black text-gray-900">{{ $currentStock }}</span>
                    <span class="h-10 w-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold">📦</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Inbound</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-black text-emerald-600">+{{ $totalIn }}</span>
                    <span class="h-10 w-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">📥</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Outbound</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-black text-orange-600">-{{ $totalOut }}</span>
                    <span class="h-10 w-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center font-bold">📤</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Selling Price</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-black text-blue-600">${{ number_format($product->selling_price, 2) }}</span>
                    <span class="h-10 w-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold">💰</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Details Column -->
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-50 pb-4">Product Information</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Generic Name</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $product->generic_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Unit Type</p>
                            <p class="text-sm font-semibold text-gray-700 capitalize">{{ $product->unit }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Reorder Level</p>
                            <p class="text-sm font-semibold text-red-600">{{ $product->reorder_level }} units</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Prescription Required</p>
                            <p class="text-sm font-semibold {{ $product->is_prescription_required ? 'text-orange-600' : 'text-gray-700' }}">
                                {{ $product->is_prescription_required ? '⚠️ Yes' : 'No' }}
                            </p>
                        </div>
                        <div class="pt-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Description</p>
                            <p class="text-xs text-gray-500 leading-relaxed mt-1">{{ $product->description ?? 'No description provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movement Table Column -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Stock Movement History</h3>
                        <span class="text-[10px] font-bold bg-gray-100 px-2 py-1 rounded text-gray-500 uppercase">Recent 50 Entries</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-100">Date</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-100">Type</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-100">In / Out</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-100">Balance</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-100">Ref / User</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($movements as $mov)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $mov->created_at->format('Y-m-d') }}</div>
                                        <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $mov->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold uppercase tracking-widest
                                            @if($mov->type == 'purchase') bg-blue-50 text-blue-700 @elseif($mov->type == 'sale') bg-orange-50 text-orange-700 @else bg-purple-50 text-purple-700 @endif">
                                            {{ str_replace('_', ' ', $mov->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($mov->quantity_in > 0)
                                            <span class="text-emerald-600 font-black">+{{ $mov->quantity_in }}</span>
                                        @else
                                            <span class="text-red-500 font-black">-{{ $mov->quantity_out }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $mov->balance }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-medium text-gray-700">{{ $mov->notes }}</div>
                                        <div class="text-[10px] text-gray-400 capitalize">{{ $mov->creator->name ?? 'System' }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No movements recorded yet.</td>
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
