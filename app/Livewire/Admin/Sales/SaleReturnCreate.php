<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\Inventory;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class SaleReturnCreate extends Component
{
    public $sale_id;
    public $sale;
    public $items = [];
    public $return_no;
    public $return_date;
    public $notes;
    public $total_amount = 0;

    public function mount()
    {
        $this->return_date = date('Y-m-d');
        $this->return_no = 'RET-' . strtoupper(uniqid());
        
        if (request()->has('sale_id')) {
            $this->loadSale(request()->sale_id);
        }
    }

    public function loadSale($saleId)
    {
        $this->sale = Sale::with(['items.product', 'items.store'])->find($saleId);
        if (!$this->sale) {
            session()->flash('error', 'Sale not found.');
            return;
        }

        $this->sale_id = $this->sale->id;
        $this->items = [];

        foreach ($this->sale->items as $item) {
            // Calculate previously returned quantity
            $alreadyReturned = SaleReturnItem::where('sale_item_id', $item->id)->sum('quantity');
            $maxReturnable = $item->quantity - $alreadyReturned;

            if ($maxReturnable > 0) {
                $this->items[] = [
                    'sale_item_id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'store_id' => $item->store_id,
                    'store_name' => $item->store->name,
                    'batch_no' => $item->batch_no,
                    'sold_quantity' => $item->quantity,
                    'already_returned' => $alreadyReturned,
                    'max_returnable' => $maxReturnable,
                    'return_quantity' => 0,
                    'unit_price' => $item->unit_price,
                    'total' => 0,
                ];
            }
        }
    }

    public function calculateTotals()
    {
        $this->total_amount = 0;
        foreach ($this->items as $index => $item) {
            $qty = (float)($item['return_quantity'] ?? 0);
            $this->items[$index]['total'] = $qty * (float)$item['unit_price'];
            $this->total_amount += $this->items[$index]['total'];
        }
    }

    public function store()
    {
        $this->validate([
            'sale_id' => 'required',
            'return_date' => 'required|date',
            'return_no' => 'required|unique:sale_returns,return_no',
            'items.*.return_quantity' => 'required|numeric|min:0',
        ]);

        $hasReturns = collect($this->items)->sum('return_quantity') > 0;
        if (!$hasReturns) {
            session()->flash('error', 'Please specify at least one item to return.');
            return;
        }

        // Validate quantities again to be safe
        foreach ($this->items as $item) {
            if ($item['return_quantity'] > $item['max_returnable']) {
                session()->flash('error', "Return quantity for {$item['product_name']} exceeds sold quantity.");
                return;
            }
        }

        DB::transaction(function () {
            $saleReturn = SaleReturn::create([
                'sale_id' => $this->sale_id,
                'return_no' => $this->return_no,
                'return_date' => $this->return_date,
                'total_amount' => $this->total_amount,
                'notes' => $this->notes,
                'created_by' => auth()->id(),
            ]);

            foreach ($this->items as $itemData) {
                if ($itemData['return_quantity'] <= 0) continue;

                SaleReturnItem::create([
                    'sale_return_id' => $saleReturn->id,
                    'sale_item_id' => $itemData['sale_item_id'],
                    'product_id' => $itemData['product_id'],
                    'store_id' => $itemData['store_id'],
                    'batch_no' => $itemData['batch_no'],
                    'quantity' => $itemData['return_quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $itemData['total'],
                ]);

                // Update Inventory
                $inventory = Inventory::where('product_id', $itemData['product_id'])
                    ->where('store_id', $itemData['store_id'])
                    ->where('batch_no', $itemData['batch_no'])
                    ->first();

                if ($inventory) {
                    $inventory->increment('quantity', $itemData['return_quantity']);
                } else {
                    // If batch was somehow deleted or not found (unlikely), create it back?
                    // Better to find a compatible inventory or create one.
                    Inventory::create([
                        'product_id' => $itemData['product_id'],
                        'store_id' => $itemData['store_id'],
                        'batch_no' => $itemData['batch_no'],
                        'quantity' => $itemData['return_quantity'],
                        'expiry_date' => now()->addYear(), // Dummy if not found
                    ]);
                }

                $newBalance = Inventory::where('product_id', $itemData['product_id'])->sum('quantity');

                // Stock Movement
                StockMovement::create([
                    'product_id' => $itemData['product_id'],
                    'store_id' => $itemData['store_id'],
                    'type' => 'return',
                    'reference_type' => SaleReturn::class,
                    'reference_id' => $saleReturn->id,
                    'batch_no' => $itemData['batch_no'],
                    'quantity_in' => $itemData['return_quantity'],
                    'quantity_out' => 0,
                    'balance' => $newBalance,
                    'notes' => 'Stock return via Return #' . $this->return_no,
                    'created_by' => auth()->id(),
                ]);
            }
        });

        session()->flash('success', 'Sale return processed successfully!');
        return redirect()->route('admin.sales.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.sales.sale-return-create');
    }
}
