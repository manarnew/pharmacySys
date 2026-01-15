<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Inventory;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Store;
use Livewire\WithPagination;

class InventoryIndex extends Component
{
    use WithPagination;

    public $filter_product_id, $filter_store_id;
    public $activeTab = 'stock'; // 'stock' or 'movements'

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function resetFilters()
    {
        $this->reset(['filter_product_id', 'filter_store_id']);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $query = Inventory::with(['product', 'store'])->latest();

        if ($this->filter_product_id) {
            $query->where('product_id', $this->filter_product_id);
        }

        if ($this->filter_store_id) {
            $query->where('store_id', $this->filter_store_id);
        }

        $stock = $query->get();

        $movements = StockMovement::with(['product', 'store', 'creator', 'reference'])
            ->latest()
            ->take(500)
            ->get();

        $products = Product::where('status', 'active')->get();
        $stores = Store::where('status', 'active')->get();

        return view('livewire.admin.inventory.inventory-index', compact('stock', 'movements', 'products', 'stores'));
    }
}
