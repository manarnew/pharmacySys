<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\User;
use App\Models\Clinic;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Spatie\Permission\Models\Role;

class UserIndex extends Component
{
    use WithPagination;

    public $name, $email, $password, $user_id, $clinic_id, $role;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user_id)],
            'password' => $this->isEditing ? 'nullable|min:6' : 'required|min:6',
            'clinic_id' => 'nullable|exists:clinics,id',
            'role' => 'required|string|exists:roles,name',
        ];
    }

    public function resetFields()
    {
        $this->reset(['name', 'email', 'password', 'user_id', 'clinic_id', 'role', 'isEditing']);
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function store()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'clinic_id' => $this->clinic_id,
        ]);

        $user->assignRole($this->role);

        $this->dispatch('user-saved', 'User created successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->clinic_id = $user->clinic_id;
        $this->role = $user->getRoleNames()->first();
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        if ($this->user_id) {
            $user = User::findOrFail($this->user_id);
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'clinic_id' => $this->clinic_id,
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $user->update($data);
            $user->syncRoles([$this->role]);

            $this->dispatch('user-saved', 'User updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            $this->dispatch('user-error', 'You cannot delete yourself!');
            return;
        }

        User::findOrFail($id)->delete();
        $this->dispatch('user-deleted', 'User deleted successfully!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $users = User::with(['clinic', 'roles'])->latest()->get();
        $clinics = Clinic::all();
        $roles = Role::all();
        return view('livewire.admin.users.user-index', compact('users', 'clinics', 'roles'));
    }
}
