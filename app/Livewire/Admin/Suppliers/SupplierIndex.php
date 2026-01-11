<?php

namespace App\Livewire\Admin\Suppliers;

use Livewire\Component;
use Livewire\Attributes\Layout;

class SupplierIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.suppliers.supplier-index');
    }
}
