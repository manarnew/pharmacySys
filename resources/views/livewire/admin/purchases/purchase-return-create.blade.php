<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-extrabold text-slate-800">{{ __('Purchase Return') }}</h2>
                        <p class="text-sm text-slate-500 mt-1">{{ __('Process a product return to a supplier') }}</p>
                    </div>
                </div>

                @if(session()->has('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                @if(!$purchase)
                    <div class="bg-slate-50 p-8 rounded-xl border-2 border-dashed border-slate-200 text-center">
                        <div class="max-w-md mx-auto">
                            <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h3 class="text-lg font-bold text-slate-700 mb-2">{{ __('Find Purchase Invoice') }}</h3>
                            <p class="text-sm text-slate-500 mb-6">{{ __('Enter the purchase invoice ID from the supplier to begin the return process.') }}</p>
                            
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.500ms="purchase_id" placeholder="{{ __('Invoice # (e.g. PUR-6785...)') }}" 
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold">#</span>
                            </div>
                            <button wire:click="loadPurchase($purchase_id)" class="mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-emerald-200">
                                {{ __('Start Return Process') }}
                            </button>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Invoice Details -->
                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Original Invoice') }}</p>
                                        <p class="text-lg font-bold text-slate-800">#{{ $purchase->invoice_no }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Purchase Date') }}</p>
                                        <p class="text-slate-700 font-medium">{{ $purchase->purchase_date->format('Y-m-d') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Supplier') }}</p>
                                        <p class="text-slate-700 font-medium">{{ $purchase->supplier->name ?? __('Unknown') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <button wire:click="$set('purchase', null)" class="text-red-500 hover:text-red-700 text-xs font-bold uppercase tracking-tight">
                                            {{ __('Cancel & Change') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Items Table -->
                            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200">
                                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Product') }}</th>
                                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Inventory Status') }}</th>
                                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Returning') }}</th>
                                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Cost') }}</th>
                                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($items as $index => $item)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-slate-800">{{ $item['product_name'] }}</div>
                                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">{{ __('Batch') }}: {{ $item['batch_no'] }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-xs text-slate-600">{{ __('Purchased') }}: {{ $item['purchased_quantity'] }}</div>
                                                <div class="text-xs font-bold {{ $item['available_in_stock'] > 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                                    {{ __('In Stock') }}: {{ $item['available_in_stock'] }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="relative w-24">
                                                    <input type="number" wire:model.live.debounce.500ms="items.{{ $index }}.return_quantity" 
                                                        wire:keyup="calculateTotals"
                                                        max="{{ $item['max_returnable'] }}" min="0" step="1"
                                                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold text-emerald-600 outline-none focus:ring-2 focus:ring-emerald-500"
                                                        {{ $item['max_returnable'] <= 0 ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-slate-600">
                                                ${{ number_format($item['unit_price'], 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-bold text-slate-800">
                                                ${{ number_format($item['total'], 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Summary Sidebar -->
                        <div class="space-y-6">
                            <div class="bg-slate-800 text-white rounded-2xl p-6 shadow-xl shadow-slate-200 relative overflow-hidden">
                                <div class="relative z-10">
                                    <h3 class="text-lg font-bold mb-6 flex justify-between items-center">
                                        {{ __('Return Summary') }}
                                        <span class="text-[10px] font-bold bg-slate-700 px-2 py-1 rounded text-slate-300 uppercase letter tracking-widest">{{ __('Supplier') }}</span>
                                    </h3>
                                    
                                    <div class="space-y-4 mb-8">
                                        <div class="flex justify-between text-sm text-slate-400">
                                            <span>{{ __('Subtotal') }}</span>
                                            <span class="font-bold text-white">${{ number_format($total_amount, 2) }}</span>
                                        </div>
                                        <div class="pt-4 border-t border-slate-700 flex justify-between items-center text-xl font-black">
                                            <span>{{ __('Collection') }}</span>
                                            <span class="text-emerald-400">${{ number_format($total_amount, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">{{ __('Return Date') }}</label>
                                            <input type="date" wire:model="return_date" class="w-full bg-slate-700 border-none rounded-lg text-sm py-2 px-3 outline-none focus:ring-2 focus:ring-blue-500 transition">
                                        </div>
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">{{ __('Notes') }}</label>
                                            <textarea wire:model="notes" rows="3" class="w-full bg-slate-700 border-none rounded-lg text-sm py-2 px-3 outline-none focus:ring-2 focus:ring-blue-500 transition placeholder-slate-500" placeholder="{{ __('Reason for return...') }}"></textarea>
                                        </div>
                                    </div>

                                    <button wire:click="store" class="mt-8 w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-xl transition shadow-lg shadow-emerald-900 flex items-center justify-center">
                                        {{ __('Confirm Return') }}
                                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="absolute -right-10 -bottom-10 h-40 w-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
