<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;

class OrderTable extends Component
{
    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        $this->dispatch('order-deleted');
        session()->flash('success', 'Order deleted successfully.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $orders = Order::with(['patient', 'prescription'])->orderBy('created_at', 'desc')->get();
        return view('livewire.admin.orders.order-table', [
            'orders' => $orders
        ]);
    }
}
