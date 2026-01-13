<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
{
    public $name;

    public function createPermission()
    {
        $this->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $this->name,
            'guard_name' => 'web',
        ]);

        $this->reset(['name']);
        $this->dispatch('permission-saved');
    }

    public function deletePermission($id)
    {
        Permission::find($id)?->delete();
        $this->dispatch('permission-deleted');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $permissions = Permission::all();
        return view('livewire.admin.permissions.permission-index', compact('permissions'));
    }
}
