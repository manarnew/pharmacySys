<?php

namespace App\Livewire\Admin\Customers;

use Livewire\Component;

use App\Models\Customer;
use Livewire\WithPagination;

class CustomerTable extends Component
{
    use WithPagination;

    public $name, $phone, $age, $address, $gender, $customer_id;
    public $isEditing = false;
    public $showConfirmDuplicate = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'age' => 'nullable|integer|min:0',
        'address' => 'nullable|string|max:500',
        'gender' => 'nullable|in:male,female',
    ];

    public function resetFields()
    {
        $this->reset(['name', 'phone', 'age', 'address', 'gender', 'customer_id', 'isEditing', 'showConfirmDuplicate']);
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function checkDuplicate()
    {
        $this->validate();

        $duplicate = Customer::where('name', $this->name)
            ->where('phone', $this->phone)
            ->first();

        if ($duplicate && !$this->showConfirmDuplicate) {
            $this->showConfirmDuplicate = true;
            return;
        }

        $this->store();
    }

    public function store()
    {
        Customer::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'age' => $this->age,
            'address' => $this->address,
            'gender' => $this->gender,
            'date' => now()->toDateString(),
            'created_by' => auth()->id(),
        ]);

        $this->dispatch('customer-saved', 'Customer saved successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customer_id = $id;
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->age = $customer->age;
        $this->address = $customer->address;
        $this->gender = $customer->gender;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        if ($this->customer_id) {
            $customer = Customer::findOrFail($this->customer_id);
            $customer->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'age' => $this->age,
                'address' => $this->address,
                'gender' => $this->gender,
                'updated_by' => auth()->id(),
            ]);

            $this->dispatch('customer-saved', 'Customer updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Customer::findOrFail($id)->delete();
        $this->dispatch('customer-deleted', 'Customer deleted successfully!');
    }

    public function render()
    {
        $customers = Customer::with(['creator', 'updater'])->latest()->get();
        return view('livewire.admin.customers.customer-table', compact('customers'))
            ->layout('layouts.admin');
    }
}
