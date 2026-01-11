<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use Livewire\Attributes\Layout;

class OrderIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.orders.order-index');
    }
}
