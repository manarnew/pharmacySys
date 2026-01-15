<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\Layout;

class CustomerShow extends Component
{
    public $customer;

    public function mount()
    {
        $customer_id = request()->query('customer_id');
        $this->customer = Customer::with(['sales' => function($q) {
            $q->latest();
        }])->findOrFail($customer_id);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.customers.customer-show');
    }
}

