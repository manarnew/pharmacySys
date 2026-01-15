<?php

namespace App\Livewire\Admin\Stores;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Store;
use App\Models\Branch;
use Livewire\WithPagination;

class StoreIndex extends Component
{
    use WithPagination;

    public $name, $location, $branch_id, $status = 'active';
    public $store_id;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'branch_id' => 'nullable|exists:branches,id',
            'status' => 'required|string',
        ];
    }

    public function resetFields()
    {
        $this->reset(['name', 'location', 'branch_id', 'status', 'store_id', 'isEditing']);
        $this->status = 'active';
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function store()
    {
        $this->validate();

        Store::create([
            'name' => $this->name,
            'location' => $this->location,
            'branch_id' => $this->branch_id,
            'status' => $this->status,
        ]);

        $this->dispatch('store-saved', 'Store created successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $store = Store::findOrFail($id);
        $this->store_id = $id;
        $this->name = $store->name;
        $this->location = $store->location;
        $this->branch_id = $store->branch_id;
        $this->status = $store->status;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        if ($this->store_id) {
            $store = Store::findOrFail($this->store_id);
            $store->update([
                'name' => $this->name,
                'location' => $this->location,
                'branch_id' => $this->branch_id,
                'status' => $this->status,
            ]);

            $this->dispatch('store-saved', 'Store updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Store::findOrFail($id)->delete();
        $this->dispatch('store-deleted', 'Store deleted successfully!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $stores = Store::with('branch')->latest()->get();
        $branches = Branch::all();
        return view('livewire.admin.stores.store-index', compact('stores', 'branches'));
    }
}
