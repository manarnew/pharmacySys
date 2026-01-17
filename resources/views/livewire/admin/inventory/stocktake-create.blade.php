<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ __('New Stocktake') }}</h1>
            <p class="mt-1 text-sm text-gray-500">{{ __('Perform a physical inventory count and reconcile stock.') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">{{ __('Cancel') }}</a>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-center">
            <div class="flex items-center">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500' }} font-bold text-sm">1</div>
                    <span class="mt-1 text-xs font-medium {{ $step >= 1 ? 'text-blue-600' : 'text-gray-500' }}">{{ __('Setup') }}</span>
                </div>
                <div class="w-16 h-1 {{ $step >= 2 ? 'bg-blue-600' : 'bg-gray-200' }} mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $step >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500' }} font-bold text-sm">2</div>
                    <span class="mt-1 text-xs font-medium {{ $step >= 2 ? 'text-blue-600' : 'text-gray-500' }}">{{ __('Count') }}</span>
                </div>
                <div class="w-16 h-1 {{ $step >= 3 ? 'bg-blue-600' : 'bg-gray-200' }} mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $step >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500' }} font-bold text-sm">3</div>
                    <span class="mt-1 text-xs font-medium {{ $step >= 3 ? 'text-blue-600' : 'text-gray-500' }}">{{ __('Review') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 1: Setup -->
    @if($step === 1)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Stocktake Setup') }}</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Store') }}</label>
                    <select wire:model="store_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2.5">
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                    @error('store_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date') }}</label>
                    <input type="date" wire:model="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2.5">
                    @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes') }} (Optional)</label>
                    <textarea wire:model="notes" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 sm:text-sm border p-2.5" placeholder="Reason for stocktake, participants, etc."></textarea>
                </div>

                <div class="pt-4">
                    <button wire:click="startCount" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        {{ __('Start Counting') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Step 2: Count -->
    @if($step === 2)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('Enter Actual Counts') }}</h3>
                <div class="text-sm text-gray-500">
                    Store: <span class="font-medium text-gray-900">{{ $stores->find($store_id)?->name }}</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Product') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Batch Info') }}</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">{{ __('System Qty') }}</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">{{ __('Actual Qty') }}</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">{{ __('Diff') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($items as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item['product_name'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">Batch: {{ $item['batch_no'] }}</div>
                                    <div class="text-xs text-gray-400">Exp: {{ $item['expiry_date'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    {{ $item['system_quantity'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" 
                                           wire:model.live.debounce.300ms="items.{{ $index }}.actual_quantity"
                                           wire:change="updateQuantity({{ $index }}, $event.target.value)"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-1 text-center font-bold">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php $diff = ($items[$index]['actual_quantity'] ?? 0) - $item['system_quantity']; @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $diff == 0 ? 'bg-green-100 text-green-800' : ($diff < 0 ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $diff > 0 ? '+' : '' }}{{ $diff }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                    {{ __('No inventory items found in this store to count.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                <button wire:click="backToStore" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Back') }}
                </button>
                @if(count($items) > 0)
                <button wire:click="proceedToReview" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Review Differences') }}
                </button>
                @endif
            </div>
        </div>
    @endif

    <!-- Step 3: Review -->
    @if($step === 3)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('Review & Submit') }}</h3>
                <p class="text-sm text-gray-500">{{ __('Please review the discrepancies before submitting.') }}</p>
            </div>

            <div class="p-6">
                @php
                    $discrepancies = collect($items)->filter(function($i) { return ($i['actual_quantity'] - $i['system_quantity']) != 0; });
                @endphp

                @if($discrepancies->count() > 0)
                    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">{{ __('Discrepancies Found') }}</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>{{ __('You have recorded') }} <strong>{{ $discrepancies->count() }}</strong> {{ __('items with quantity differences. These will require approval.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 mb-6">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Product') }}</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">{{ __('System') }}</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">{{ __('Actual') }}</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">{{ __('Diff') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($discrepancies as $item)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900">{{ $item['product_name'] }} <span class="text-xs text-gray-500">({{ $item['batch_no'] }})</span></td>
                                <td class="px-4 py-2 text-sm text-center text-gray-500">{{ $item['system_quantity'] }}</td>
                                <td class="px-4 py-2 text-sm text-center text-gray-900 font-bold">{{ $item['actual_quantity'] }}</td>
                                <td class="px-4 py-2 text-sm text-center">
                                    <span class="text-{{ ($item['actual_quantity'] - $item['system_quantity']) < 0 ? 'red' : 'blue' }}-600 font-bold">
                                        {{ $item['actual_quantity'] - $item['system_quantity'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
                        <svg class="h-5 w-5 text-green-400 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-green-800 font-medium">{{ __('Perfect Match! No discrepancies found.') }}</span>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     <button wire:click="save('draft')" class="w-full justify-center px-4 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        {{ __('Save as Draft') }}
                    </button>
                    <button wire:click="save('pending_approval')" class="w-full justify-center px-4 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        {{ __('Submit for Approval') }}
                    </button>
                </div>
                
                <div class="mt-4 text-center">
                    <button wire:click="backToCount" class="text-sm text-gray-500 hover:text-gray-900">{{ __('Back to Count') }}</button>
                </div>
            </div>
        </div>
    @endif
</div>
