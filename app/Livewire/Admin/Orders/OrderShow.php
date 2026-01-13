<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

class OrderShow extends Component
{
    public $order;
    public $patient;
    public $prescription;

    public function mount()
    {
        $order_id = request()->query('order_id');
        if ($order_id) {
            $this->order = Order::with(['patient', 'prescription'])->find($order_id);
            if ($this->order) {
                $this->patient = $this->order->patient;
                $this->prescription = $this->order->prescription;
            }
        }
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.orders.order-show');
    }
}
