<div class="space-y-6"
     @settings-saved.window="Swal.fire({ icon: 'success', title: 'Success', text: $event.detail })">
    
    <!-- Header -->
    <div class="mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">{{ __('Site Settings') }}</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">{{ __('View and update your site configuration.') }}</p>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form wire:submit.prevent="save" enctype="multipart/form-data" class="p-4 sm:p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Site Name -->
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">{{ __('Site Name') }}</label>
                    <input type="text" wire:model="site_name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2.5 transition-all" placeholder="{{ __('Enter site name') }}">
                    @error('site_name') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Site Description -->
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">{{ __('Site Description') }}</label>
                    <input type="text" wire:model="site_description" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2.5 transition-all" placeholder="{{ __('Enter site description') }}">
                    @error('site_description') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Logo Upload -->
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">{{ __('Site Logo') }}</label>
                    <div class="flex items-start space-x-4">
                        @if($current_logo)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $current_logo) }}" alt="Current Logo" class="h-20 w-20 object-contain rounded-lg border-2 border-gray-200 p-2 bg-white">
                                <p class="text-xs text-gray-500 mt-1 text-center">{{ __('Current') }}</p>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" wire:model="logo" accept="image/*" id="logo-upload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                            <p class="mt-1 text-xs text-gray-500">{{ __('PNG, JPG, GIF up to 2MB') }}</p>
                            
                            <!-- Loading Indicator -->
                            <div wire:loading wire:target="logo" class="mt-2">
                                <div class="flex items-center text-blue-600">
                                    <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm">{{ __('Uploading...') }}</span>
                                </div>
                            </div>
                            
                            @error('logo') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @if($logo)
                        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm font-medium text-green-800 mb-2">{{ __('Preview:') }}</p>
                            <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="h-20 w-20 object-contain rounded-lg border-2 border-green-300 p-2 bg-white">
                            <p class="text-xs text-green-600 mt-1">{{ __('Click "Save Changes" to upload this logo') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Phone -->
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">{{ __('Phone Number') }}</label>
                    <input type="text" wire:model="phone" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2.5 transition-all" placeholder="{{ __('Enter phone number') }}">
                    @error('phone') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">{{ __('Email Address') }}</label>
                    <input type="email" wire:model="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2.5 transition-all" placeholder="{{ __('Enter email address') }}">
                    @error('email') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2 space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">{{ __('Address') }}</label>
                    <textarea wire:model="address" rows="2" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2.5 transition-all" placeholder="{{ __('Enter pharmacy address') }}"></textarea>
                    @error('address') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Footer Text -->
                <div class="md:col-span-2 space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">{{ __('Footer Text') }}</label>
                    <input type="text" wire:model="footer_text" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2.5 transition-all" placeholder="{{ __('Enter footer text') }}">
                    @error('footer_text') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
