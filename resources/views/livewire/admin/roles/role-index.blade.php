<div x-data="{ showModal: false }"
     x-init="$watch('showModal', value => { if (!value) setTimeout(initDataTable, 100) })"
     x-on:open-role-modal.window="showModal = true"
     x-on:role-saved.window="showModal = false; $wire.$refresh()">
    
    <div class="space-y-6">
        <!-- Header -->
        <div class="mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">{{ __('User Roles') }}</h1>
                <p class="mt-1 text-xs sm:text-sm text-gray-500">{{ __('Manage user roles and assign permissions.') }}</p>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0 text-green-400">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Roles Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-3 sm:p-4 md:p-6">
                <!-- Add Button inside table container -->
                <div class="flex justify-end mb-4">
                    @can('create_role')
                    <button wire:click="openModal" type="button" class="inline-flex items-center rounded-lg bg-indigo-600 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white shadow-sm hover:bg-indigo-700 transition">
                        <svg class="mr-1 sm:mr-2 -ml-1 h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('Create New Role') }}</span>
                        <span class="sm:hidden">{{ __('New') }}</span>
                    </button>
                    @endcan
                </div>
                <table id="rolesTable" class="display w-full" style="width:100%">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700">{{ __('Role Name') }}</th>
                            <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700">{{ __('Permissions') }}</th>
                            <th class="text-center py-4 px-6 text-sm font-semibold text-gray-700">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($roles as $role)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 text-sm font-bold text-gray-900">{{ $role->name }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($role->permissions as $permission)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @if($role->permissions->count() === 0)
                                            <span class="text-gray-400 italic text-xs">{{ __('No permissions assigned') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @can('edit_role')
                                        <button wire:click="editRole({{ $role->id }})" 
                                                class="p-2 text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors" 
                                                title="{{ __('Edit') }}">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        @endcan

                                        @can('delete_role')
                                        <button wire:click="deleteRole({{ $role->id }})" 
                                                wire:confirm="{{ __('Delete this role? This cannot be undone.') }}" 
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

    <!-- Role Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" x-transition.opacity x-on:click="showModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                
                <div class="bg-white px-8 pt-8 pb-6">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <h3 class="text-2xl leading-6 font-bold text-gray-900 mb-6">
                                {{ $isEdit ? __('Edit Role') : __('Create New Role') }}
                            </h3>
                            
                            <div class="space-y-6">
                                <!-- Role Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Role Name') }}</label>
                                    <input type="text" wire:model="name" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border" placeholder="e.g. Administrator">
                                    @error('name') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <!-- Permissions Grid -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-4">{{ __('Assign Permissions') }}</label>
                                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 max-h-64 overflow-y-auto">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($permissions as $permission)
                                                <div class="flex items-center space-x-3 bg-white p-3 rounded-lg border border-gray-100 shadow-sm hover:border-indigo-300 transition-colors">
                                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->name }}" class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                    <span class="text-sm font-medium text-gray-700">{{ $permission->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if($permissions->count() === 0)
                                        <p class="text-xs text-amber-600 mt-2 italic">{{ __('Please create some permissions first.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-4 sm:flex sm:flex-row-reverse">
                    <button wire:click="{{ $isEdit ? 'updateRole' : 'createRole' }}" type="button" class="w-full inline-flex justify-center rounded-xl bg-indigo-600 px-6 py-3 text-base font-bold text-white shadow-lg hover:bg-indigo-700 transition sm:ml-3 sm:w-auto">
                        {{ $isEdit ? __('Save Changes') : __('Create Role') }}
                    </button>
                    <button x-on:click="showModal = false" type="button" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl bg-white border border-gray-300 px-6 py-3 text-base font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition sm:w-auto">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#rolesTable')) {
                $('#rolesTable').DataTable().destroy();
            }
            
            $('#rolesTable').DataTable({
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                dom: 'frtip',
                language: {
                    search: "",
                    searchPlaceholder: "{{ __('Search roles...') }}",
                    emptyTable: "{{ __('No roles found') }}",
                    paginate: {
                        first: "{{ __('First') }}",
                        last: "{{ __('Last') }}",
                        next: "{{ __('Next') }}",
                        previous: "{{ __('Previous') }}"
                    }
                },
                initComplete: function() {
                    $('.dataTables_filter input').attr('placeholder', '{{ __('Search roles...') }}');
                }
            });
        }

        document.addEventListener('livewire:navigated', initDataTable);
        
        document.addEventListener('livewire:initialized', () => {
            @foreach(['role-saved', 'role-deleted', 'open-edit-modal'] as $event)
                Livewire.on('{{ $event }}', () => {
                    setTimeout(initDataTable, 100);
                });
            @endforeach
        });
    </script>
