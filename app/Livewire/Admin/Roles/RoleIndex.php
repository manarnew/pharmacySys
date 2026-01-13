<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleIndex extends Component
{
    public $name;
    public $role_id;
    public $selectedPermissions = [];
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|unique:roles,name',
    ];

    public function openModal()
    {
        $this->reset(['name', 'role_id', 'selectedPermissions', 'isEdit']);
        $this->dispatch('open-role-modal');
    }

    public function createRole()
    {
        $this->validate();

        $role = Role::create(['name' => $this->name, 'guard_name' => 'web']);
        $role->syncPermissions($this->selectedPermissions);

        $this->reset(['name', 'selectedPermissions']);
        $this->dispatch('role-saved');
        session()->flash('success', 'Role created successfully.');
    }

    public function editRole($id)
    {
        $this->role_id = $id;
        $role = Role::findById($id);
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->isEdit = true;
        $this->dispatch('open-role-modal');
    }

    public function updateRole()
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name, ' . $this->role_id,
        ]);

        $role = Role::findById($this->role_id);
        $role->update(['name' => $this->name]);
        $role->syncPermissions($this->selectedPermissions);

        $this->reset(['name', 'selectedPermissions', 'role_id', 'isEdit']);
        $this->dispatch('role-saved');
        session()->flash('success', 'Role updated successfully.');
    }

    public function deleteRole($id)
    {
        Role::findById($id)->delete();
        $this->dispatch('role-deleted');
        session()->flash('success', 'Role deleted successfully.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.roles.role-index', [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::all(),
        ]);
    }
}
