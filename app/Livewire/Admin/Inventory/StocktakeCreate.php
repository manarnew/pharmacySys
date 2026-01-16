<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Stocktake;
use App\Models\StocktakeItem;
use App\Models\Store;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class StocktakeCreate extends Component
{
    public $store_id;
    public $date;
    public $notes;
    public $items = []; // [product_id, batch_no, expiry, system_qty, actual_qty]
    
    public $step = 1; // 1: Select Store, 2: Count, 3: Review

    public function mount()
    {
        // Check permission
        if (!auth()->user()->can('stocktake_create')) {
            abort(403);
        }

        $this->date = date('Y-m-d');
        
        $firstStore = Store::where('status', 'active')->first();
        if ($firstStore) {
            $this->store_id = $firstStore->id;
        }
    }

    public function startCount()
    {
        $this->validate([
            'store_id' => 'required|exists:stores,id',
            'date' => 'required|date',
        ]);

        // Load current inventory for this store
        // We get all products that have inventory records, plus active products with 0 stock
        // For simplicity, let's pull all inventory records for this store first.
        
        $inventoryItems = Inventory::with('product')
            ->where('store_id', $this->store_id)
            ->where('quantity', '>', 0)
            ->orderBy('product_id')
            ->get();

        $this->items = $inventoryItems->map(function($inv) {
            return [
                'product_id' => $inv->product_id,
                'product_name' => $inv->product->name,
                'batch_no' => $inv->batch_no,
                'expiry_date' => $inv->expiry_date ? $inv->expiry_date->format('Y-m-d') : null,
                'system_quantity' => $inv->quantity,
                'actual_quantity' => $inv->quantity, // Default to system qty
                'cost_price' => $inv->cost_price ?? 0, // Assuming inventory tracks cost or we fetch from product
                'difference' => 0,
            ];
        })->toArray();

        // Also add products that are "out of stock" but exist? 
        // For now, let's focus on reconciling existing batches. 
        // A full stocktake might need to list ALL products, but that can be huge.
        // Let's rely on adding "unlisted" items manually if needed (future feature).

        $this->step = 2;
    }

    public function updateQuantity($index, $qty)
    {
        $this->items[$index]['actual_quantity'] = $qty;
        $this->items[$index]['difference'] = $qty - $this->items[$index]['system_quantity'];
    }

    public function proceedToReview()
    {
        // Simple validation
        $this->step = 3;
    }

    public function backToCount()
    {
        $this->step = 2;
    }

    public function backToStore()
    {
        $this->step = 1;
        $this->items = [];
    }

    public function save($status = 'draft')
    {
        // Status: 'draft' or 'pending_approval'
        
        $stocktake = DB::transaction(function () use ($status) {
            $ref = 'ST-' . strtoupper(uniqid());
            
            $stocktake = Stocktake::create([
                'store_id' => $this->store_id,
                'reference' => $ref,
                'date' => $this->date,
                'status' => $status,
                'notes' => $this->notes,
                'created_by' => auth()->id(),
            ]);

            foreach ($this->items as $item) {
                StocktakeItem::create([
                    'stocktake_id' => $stocktake->id,
                    'product_id' => $item['product_id'],
                    'batch_no' => $item['batch_no'],
                    'expiry_date' => $item['expiry_date'],
                    'system_quantity' => $item['system_quantity'],
                    'actual_quantity' => $item['actual_quantity'],
                    'difference' => $item['actual_quantity'] - $item['system_quantity'],
                    'cost_price' => $item['cost_price'] ?? 0,
                ]);
            }
            
            return $stocktake;
        });

        if ($status === 'draft') {
            session()->flash('success', 'Stocktake saved as draft.');
        } else {
            session()->flash('success', 'Stocktake submitted for approval.');
        }

        return redirect()->route('admin.stocktakes.show', $stocktake->id);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $stores = Store::where('status', 'active')->get();
        return view('livewire.admin.inventory.stocktake-create', compact('stores'));
    }
}
