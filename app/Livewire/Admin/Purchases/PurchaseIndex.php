<?php

namespace App\Livewire\Admin\Purchases;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Store;
use App\Models\Inventory;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class PurchaseIndex extends Component
{
    use WithPagination;

    public $supplier_id, $invoice_no, $purchase_date, $discount = 0, $tax = 0, $notes;
    public $items = []; // Array of items: ['product_id', 'store_id', 'batch_no', 'expiry_date', 'quantity', 'unit_price']
    public $purchase_id;
    public $isEditing = false;
    public $showCreateModal = false;

    public function mount()
    {
        $this->purchase_date = date('Y-m-d');
        $this->items = [
            ['product_id' => '', 'store_id' => '', 'batch_no' => '', 'expiry_date' => '', 'quantity' => 1, 'unit_price' => 0]
        ];
        $this->calculateTotals();
    }

    protected function rules()
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_no' => 'required|string|max:255|unique:purchases,invoice_no,' . $this->purchase_id,
            'purchase_date' => 'required|date',
            'discount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.store_id' => 'required|exists:stores,id',
            'items.*.batch_no' => 'required|string',
            'items.*.expiry_date' => 'required|date|after:today',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'store_id' => '', 'batch_no' => '', 'expiry_date' => '', 'quantity' => 1, 'unit_price' => 0];
        $this->dispatch('item-added');
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function resetFields()
    {
        $this->reset(['supplier_id', 'invoice_no', 'discount', 'tax', 'notes', 'items', 'purchase_id', 'isEditing', 'showCreateModal']);
        $this->purchase_date = date('Y-m-d');
        $this->items = [
            ['product_id' => '', 'store_id' => '', 'batch_no' => '', 'expiry_date' => '', 'quantity' => 1, 'unit_price' => 0]
        ];
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showCreateModal = true;
        $this->calculateTotals();
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'items') || in_array($propertyName, ['discount', 'tax'])) {
            $this->calculateTotals();
        }
    }

    public function calculateTotals()
    {
        $subtotal = collect($this->items)->sum(fn($i) => (float)($i['quantity'] ?? 0) * (float)($i['unit_price'] ?? 0));
        $this->total = $subtotal - (float)$this->discount + (float)$this->tax;
    }

    public function setProduct($index, $productId)
    {
        $this->items[$index]['product_id'] = $productId;
    }

    public function store()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $subtotal = collect($this->items)->sum(fn($i) => (float)$i['quantity'] * (float)$i['unit_price']);
                $total = $subtotal - (float)$this->discount + (float)$this->tax;

                $purchase = Purchase::create([
                    'supplier_id' => $this->supplier_id,
                    'invoice_no' => $this->invoice_no,
                    'purchase_date' => $this->purchase_date,
                    'subtotal' => $subtotal,
                    'discount' => $this->discount,
                    'tax' => $this->tax,
                    'total' => $total,
                    'status' => 'received',
                    'notes' => $this->notes,
                    'created_by' => auth()->id(),
                ]);

                foreach ($this->items as $itemData) {
                    $itemTotal = (float)$itemData['quantity'] * (float)$itemData['unit_price'];
                    
                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $itemData['product_id'],
                        'store_id' => $itemData['store_id'],
                        'batch_no' => $itemData['batch_no'],
                        'expiry_date' => $itemData['expiry_date'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $itemTotal,
                    ]);

                    // Update Inventory
                    $inventory = Inventory::updateOrCreate(
                        [
                            'store_id' => $itemData['store_id'],
                            'product_id' => $itemData['product_id'],
                            'batch_no' => $itemData['batch_no'],
                        ],
                        [
                            'expiry_date' => $itemData['expiry_date'],
                            'quantity' => DB::raw("quantity + " . (int)$itemData['quantity'])
                        ]
                    );

                    // Record Stock Movement
                    $currentBalance = Inventory::where('product_id', $itemData['product_id'])->sum('quantity');

                    StockMovement::create([
                        'product_id' => $itemData['product_id'],
                        'store_id' => $itemData['store_id'],
                        'type' => 'purchase',
                        'reference_type' => Purchase::class,
                        'reference_id' => $purchase->id,
                        'batch_no' => $itemData['batch_no'],
                        'quantity_in' => $itemData['quantity'],
                        'quantity_out' => 0,
                        'balance' => $currentBalance,
                        'notes' => 'Stock in via Purchase #' . $this->invoice_no,
                        'created_by' => auth()->id(),
                    ]);
                }
            });

            $this->dispatch('purchase-saved', 'Purchase recorded and stock updated!');
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving purchase: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        // For deleting, we should probably reverse the stock, but let's keep it simple for now or restrict it.
        $purchase = Purchase::findOrFail($id);
        
        DB::transaction(function () use ($purchase) {
            foreach ($purchase->items as $item) {
                // Reverse inventory
                $inventory = Inventory::where('store_id', $item->store_id)
                    ->where('product_id', $item->product_id)
                    ->where('batch_no', $item->batch_no)
                    ->first();
                
                if ($inventory) {
                    $inventory->decrement('quantity', $item->quantity);
                }

                // Movement Record
                StockMovement::create([
                    'product_id' => $item->product_id,
                    'store_id' => $item->store_id,
                    'type' => 'adjustment',
                    'batch_no' => $item->batch_no,
                    'quantity_in' => 0,
                    'quantity_out' => $item->quantity,
                    'balance' => Inventory::where('product_id', $item->product_id)->sum('quantity'),
                    'notes' => 'Purchase deletion #' . $purchase->invoice_no,
                    'created_by' => auth()->id(),
                ]);
            }
            $purchase->delete();
        });

        $this->dispatch('purchase-deleted', 'Purchase deleted and stock adjusted!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $purchases = Purchase::with(['supplier', 'creator'])->latest()->get();
        $stores = Store::where('status', 'active')->get();
        return view('livewire.admin.purchases.purchase-index', compact('purchases', 'stores'));
    }
}
