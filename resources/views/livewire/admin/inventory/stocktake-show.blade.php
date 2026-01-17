<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ __('Stocktake Report') }}</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    {{ $stocktake->status === 'completed' ? 'bg-green-100 text-green-800' : 
                       ($stocktake->status === 'pending_approval' ? 'bg-yellow-100 text-yellow-800' : 
                       ($stocktake->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                    {{ ucfirst(str_replace('_', ' ', $stocktake->status)) }}
                </span>
            </div>
            <p class="mt-1 text-sm text-gray-500">{{ __('Reference') }}: <span class="font-mono font-medium">{{ $stocktake->reference }}</span></p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.stocktakes.index') }}" class="inline-flex items-center rounded-lg bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm border border-gray-300 hover:bg-gray-50 transition-colors">
                {{ __('Back to List') }}
            </a>
            
            @if($stocktake->status === 'pending_approval' && auth()->user()->can('stocktake_approve'))
                <button wire:click="reject" wire:confirm="{{ __('Are you sure you want to REJECT this stocktake?') }}" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 transition-colors focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    {{ __('Reject') }}
                </button>
                <button wire:click="approve" wire:confirm="{{ __('Are you sure? This will update the LIVE inventory.') }}" class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 transition-colors focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    {{ __('Approve & Adjust Stock') }}
                </button>
            @endif
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Meta Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Store') }}</dt>
                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $stocktake->store->name }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</dt>
                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $stocktake->date->format('Y-m-d') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Created By') }}</dt>
                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $stocktake->creator->name }}</dd>
            </div>
            @if($stocktake->approved_by)
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Approved By') }}</dt>
                <dd class="mt-1 text-sm font-semibold text-gray-900">
                    {{ $stocktake->approver->name }} <br>
                    <span class="text-xs font-normal text-gray-500">{{ $stocktake->approved_at->diffForHumans() }}</span>
                </dd>
            </div>
             @endif
        </div>
        @if($stocktake->notes)
            <div class="mt-6 pt-4 border-t border-gray-100">
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Notes') }}</dt>
                <dd class="mt-1 text-sm text-gray-700 whitespace-pre-wrap">{{ $stocktake->notes }}</dd>
            </div>
        @endif
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">{{ __('Count Details') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Product') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Batch') }}</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('System') }}</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actual') }}</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Diff') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($stocktake->items as $item)
                        <tr class="hover:bg-gray-50 transition-colors {{ $item->difference != 0 ? 'bg-yellow-50/30' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->product->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->batch_no }}
                                <span class="text-xs text-gray-400 block">{{ $item->expiry_date?->format('Y-m-d') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                {{ $item->system_quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold text-gray-900">
                                {{ $item->actual_quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->difference != 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $item->difference > 0 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item->difference > 0 ? '+' : '' }}{{ $item->difference }}
                                    </span>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
