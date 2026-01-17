<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">{{ __('shifts.shift_management') }}</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">{{ __('shifts.open_close_manage_shifts') }}</p>
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

    <!-- Current Shift Status -->
    @if($currentShift)
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="bg-green-500 rounded-full p-2 mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-green-900">{{ __('shifts.shift_open') }}</h2>
                        <p class="text-sm text-green-700">{{ __('shifts.started_at') }}: {{ $currentShift->opened_at->format('H:i (h:i A), M d, Y') }}</p>
                    </div>
                </div>
                <button wire:click="prepareClose" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors">
                    {{ __('shifts.close_shift') }}
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                <div class="bg-white rounded-lg p-4 border border-green-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('shifts.opening_cash') }}</p>
                    <p class="text-2xl font-bold text-gray-900 font-mono">${{ number_format($currentShift->opening_cash_balance, 2) }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border border-green-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('shifts.expected_cash') }}</p>
                    <p class="text-2xl font-bold text-blue-600 font-mono">${{ number_format($currentShift->expected_cash_balance, 2) }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border border-green-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('shifts.opening_bank') }}</p>
                    <p class="text-2xl font-bold text-gray-900 font-mono">${{ number_format($currentShift->opening_bank_balance, 2) }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border border-green-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('shifts.expected_bank') }}</p>
                    <p class="text-2xl font-bold text-blue-600 font-mono">${{ number_format($currentShift->expected_bank_balance, 2) }}</p>
                </div>
            </div>

            <div class="mt-4 bg-white rounded-lg p-4 border border-green-100">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">{{ __('shifts.sales_count') }}</p>
                <p class="text-xl font-bold text-gray-900">{{ $currentShift->sales()->count() }} {{ __('shifts.transactions') }}</p>
            </div>
        </div>
    @else
        <div class="bg-gradient-to-r from-gray-50 to-slate-50 border-2 border-gray-200 rounded-xl p-8 text-center shadow-sm">
            <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('shifts.no_active_shift') }}</h3>
            <p class="text-gray-600 mb-4">{{ __('shifts.open_a_shift_to_start') }}</p>
            <button wire:click="$set('showOpenModal', true)" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition-colors inline-flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('shifts.open_new_shift') }}
            </button>
        </div>
    @endif

    <!-- Shift History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('shifts.shift_history') }}</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('shifts.date') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('shifts.duration') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('shifts.cash') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('shifts.bank') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('shifts.difference') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('shifts.status') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($shifts as $shift)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $shift->opened_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                @if($shift->closed_at)
                                    {{ $shift->opened_at->diffForHumans($shift->closed_at, true) }}
                                @else
                                    <span class="text-green-600 font-medium">{{ __('shifts.active') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-mono">
                                @if($shift->status === 'closed')
                                    ${{ number_format($shift->actual_cash_balance, 2) }}
                                @else
                                    ${{ number_format($shift->expected_cash_balance, 2) }}
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-mono">
                                @if($shift->status === 'closed')
                                    ${{ number_format($shift->actual_bank_balance, 2) }}
                                @else
                                    ${{ number_format($shift->expected_bank_balance, 2) }}
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                @if($shift->status === 'closed')
                                    @php
                                        $totalDifference = (float)$shift->cash_difference + (float)$shift->bank_difference;
                                    @endphp
                                    <span class="font-mono {{ $totalDifference == 0 ? 'text-green-600' : 'text-red-600' }}">
                                        ${{ number_format($totalDifference, 2) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($shift->status === 'open')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ __('shifts.open') }}</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ __('shifts.closed') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            {{ __('shifts.no_shift_history_found') }}
                        </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $shifts->links() }}
        </div>
    </div>

    <!-- Open Shift Modal -->
    @if($showOpenModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="$set('showOpenModal', false)">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('shifts.open_new_shift') }}</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shifts.opening_cash_balance') }}</label>
                            <input type="number" step="0.01" wire:model="openingCashBalance" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border p-2" placeholder="0.00">
                            @error('openingCashBalance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shifts.opening_bank_balance') }}</label>
                            <input type="number" step="0.01" wire:model="openingBankBalance" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border p-2" placeholder="0.00">
                            @error('openingBankBalance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button wire:click="$set('showOpenModal', false)" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                            {{ __('shifts.cancel') }}
                        </button>
                        <button wire:click="openShift" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            {{ __('shifts.open_shift') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Close Shift Modal -->
    @if($showCloseModal && $currentShift)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="$set('showCloseModal', false)">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('shifts.close_shift') }}</h3>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6 bg-blue-50 p-4 rounded-lg">
                        <div>
                            <p class="text-xs text-gray-600 uppercase">{{ __('shifts.expected_cash') }}</p>
                            <p class="text-xl font-bold text-blue-600 font-mono">${{ number_format($currentShift->expected_cash_balance, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 uppercase">{{ __('shifts.expected_bank') }}</p>
                            <p class="text-xl font-bold text-blue-600 font-mono">${{ number_format($currentShift->expected_bank_balance, 2) }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shifts.actual_cash_counted') }}</label>
                            <input type="number" step="0.01" wire:model.live="actualCashBalance" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border p-2">
                            @error('actualCashBalance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @if($actualCashBalance != $currentShift->expected_cash_balance)
                                <p class="text-xs mt-1 {{ ($actualCashBalance - $currentShift->expected_cash_balance) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ __('shifts.difference') }}: ${{ number_format($actualCashBalance - $currentShift->expected_cash_balance, 2) }}
                                </p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shifts.actual_bank_balance') }}</label>
                            <input type="number" step="0.01" wire:model.live="actualBankBalance" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border p-2">
                            @error('actualBankBalance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @if($actualBankBalance != $currentShift->expected_bank_balance)
                                <p class="text-xs mt-1 {{ ($actualBankBalance - $currentShift->expected_bank_balance) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ __('shifts.difference') }}: ${{ number_format($actualBankBalance - $currentShift->expected_bank_balance, 2) }}
                                </p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shifts.notes_optional') }}</label>
                            <textarea wire:model="closingNotes" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border p-2" placeholder="{{ __('shifts.any_discrepancies_or_notes') }}"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button wire:click="$set('showCloseModal', false)" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                            {{ __('shifts.cancel') }}
                        </button>
                        <button wire:click="closeShift" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            {{ __('shifts.close_shift') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
