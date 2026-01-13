<?php

namespace App\Livewire\Admin\Suppliers;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Supplier;
use Livewire\WithPagination;

class SupplierIndex extends Component
{
    use WithPagination;

    public $name, $phone, $email, $supplier_id;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
    ];

    public function resetFields()
    {
        $this->reset(['name', 'phone', 'email', 'supplier_id', 'isEditing']);
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function store()
    {
        $this->validate();

        Supplier::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        $this->dispatch('supplier-saved', 'Supplier created successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplier_id = $id;
        $this->name = $supplier->name;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        if ($this->supplier_id) {
            $supplier = Supplier::findOrFail($this->supplier_id);
            $supplier->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
            ]);

            $this->dispatch('supplier-saved', 'Supplier updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Supplier::findOrFail($id)->delete();
        $this->dispatch('supplier-deleted', 'Supplier deleted successfully!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $suppliers = Supplier::latest()->get();
        return view('livewire.admin.suppliers.supplier-index', compact('suppliers'));
    }
}
