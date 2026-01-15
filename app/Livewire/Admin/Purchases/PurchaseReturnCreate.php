<?php

namespace App\Livewire\Admin\Purchases;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Inventory;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class PurchaseReturnCreate extends Component
{
    public $purchase_id;
    public $purchase;
    public $items = [];
    public $return_no;
    public $return_date;
    public $notes;
    public $total_amount = 0;

    public function mount()
    {
        $this->return_date = date('Y-m-d');
        $this->return_no = 'PRET-' . strtoupper(uniqid());
        
        if (request()->has('purchase_id')) {
            $this->loadPurchase(request()->purchase_id);
        }
    }

    public function loadPurchase($purchaseId)
    {
        $this->purchase = Purchase::with(['items.product', 'items.store'])->find($purchaseId);
        if (!$this->purchase) {
            session()->flash('error', 'Purchase not found.');
            return;
        }

        $this->purchase_id = $this->purchase->id;
        $this->items = [];

        foreach ($this->purchase->items as $item) {
            // Calculate previously returned quantity
            $alreadyReturned = PurchaseReturnItem::where('purchase_item_id', $item->id)->sum('quantity');
            $maxReturnableFromPurchase = $item->quantity - $alreadyReturned;

            // Check actual inventory for this batch
            $inventory = Inventory::where('product_id', $item->product_id)
                ->where('store_id', $item->store_id)
                ->where('batch_no', $item->batch_no)
                ->first();
            
            $availableInStock = $inventory ? $inventory->quantity : 0;
            
            // Cannot return more than what we bought OR what we currently have in stock
            $maxReturnable = min($maxReturnableFromPurchase, $availableInStock);

            if ($maxReturnableFromPurchase > 0) {
                $this->items[] = [
                    'purchase_item_id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'store_id' => $item->store_id,
                    'store_name' => $item->store->name,
                    'batch_no' => $item->batch_no,
                    'purchased_quantity' => $item->quantity,
                    'already_returned' => $alreadyReturned,
                    'max_returnable_from_invoice' => $maxReturnableFromPurchase,
                    'available_in_stock' => $availableInStock,
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
            'purchase_id' => 'required',
            'return_date' => 'required|date',
            'return_no' => 'required|unique:purchase_returns,return_no',
            'items.*.return_quantity' => 'required|numeric|min:0',
        ]);

        $hasReturns = collect($this->items)->sum('return_quantity') > 0;
        if (!$hasReturns) {
            session()->flash('error', 'Please specify at least one item to return.');
            return;
        }

        foreach ($this->items as $item) {
            if ($item['return_quantity'] > $item['max_returnable']) {
                session()->flash('error', "Return quantity for {$item['product_name']} exceeds available stock or original purchase.");
                return;
            }
        }

        DB::transaction(function () {
            $purchaseReturn = PurchaseReturn::create([
                'purchase_id' => $this->purchase_id,
                'return_no' => $this->return_no,
                'return_date' => $this->return_date,
                'total_amount' => $this->total_amount,
                'notes' => $this->notes,
                'created_by' => auth()->id(),
            ]);

            foreach ($this->items as $itemData) {
                if ($itemData['return_quantity'] <= 0) continue;

                PurchaseReturnItem::create([
                    'purchase_return_id' => $purchaseReturn->id,
                    'purchase_item_id' => $itemData['purchase_item_id'],
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
                    $inventory->decrement('quantity', $itemData['return_quantity']);
                }

                $newBalance = Inventory::where('product_id', $itemData['product_id'])->sum('quantity');

                // Stock Movement
                StockMovement::create([
                    'product_id' => $itemData['product_id'],
                    'store_id' => $itemData['store_id'],
                    'type' => 'purchase_return',
                    'reference_type' => PurchaseReturn::class,
                    'reference_id' => $purchaseReturn->id,
                    'batch_no' => $itemData['batch_no'],
                    'quantity_in' => 0,
                    'quantity_out' => $itemData['return_quantity'],
                    'balance' => $newBalance,
                    'notes' => 'Stock return to supplier via Return #' . $this->return_no,
                    'created_by' => auth()->id(),
                ]);
            }
        });

        session()->flash('success', 'Purchase return processed successfully!');
        return redirect()->route('admin.purchases.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.purchases.purchase-return-create');
    }
}
