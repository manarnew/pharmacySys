<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
{
    public $name;
    public $guard_name = 'web';

    public function createPermission()
    {
        $this->validate([
            'name' => 'required|string|unique:permissions,name',
            'guard_name' => 'required|string',
        ]);

        Permission::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        $this->reset(['name', 'guard_name']);
        $this->dispatch('permission-created');
    }

    public function deletePermission($id)
    {
        Permission::find($id)?->delete();
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $permissions = Permission::all();
        return view('livewire.admin.permissions.permission-index', compact('permissions'));
    }
}
