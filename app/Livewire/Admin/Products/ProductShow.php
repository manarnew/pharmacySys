<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\StockMovement;

class ProductShow extends Component
{
    public $product;
    public $movements;

    public function mount()
    {
        $product_id = request()->query('product_id');
        $this->product = Product::with(['category'])->findOrFail($product_id);
        
        $this->movements = StockMovement::with(['store', 'creator'])
            ->where('product_id', $product_id)
            ->latest()
            ->get();
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.products.product-show', [
            'totalIn' => $this->movements->sum('quantity_in'),
            'totalOut' => $this->movements->sum('quantity_out'),
            'currentStock' => $this->product->total_stock,
        ]);
    }
}
