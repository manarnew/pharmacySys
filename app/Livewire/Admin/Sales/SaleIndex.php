<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Store;
use App\Models\Inventory;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class SaleIndex extends Component
{
    use WithPagination;

    public $customer_id, $invoice_no, $sale_date, $discount = 0, $tax = 0, $paid_amount = 0, $notes;
    public $items = []; // Array of items: ['product_id', 'store_id', 'quantity', 'unit_price']
    public $sale_id;
    public $showCreateModal = false;

    public function mount()
    {
        $this->sale_date = date('Y-m-d');
        $this->invoice_no = 'SALE-' . strtoupper(uniqid());
        $this->items = [
            ['product_id' => '', 'store_id' => '', 'quantity' => 1, 'unit_price' => 0]
        ];
    }

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'invoice_no' => 'required|string|max:255|unique:sales,invoice_no,' . $this->sale_id,
            'sale_date' => 'required|date',
            'discount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.store_id' => 'required|exists:stores,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'store_id' => '', 'quantity' => 1, 'unit_price' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        // $key is like "0.product_id"
        if (strpos($key, 'product_id') !== false) {
            $index = explode('.', $key)[0];
            $productId = $value;
            if ($productId) {
                $product = Product::find($productId);
                if ($product) {
                    $this->items[$index]['unit_price'] = $product->selling_price;
                }
            }
        }
    }

    public function resetFields()
    {
        $this->reset(['customer_id', 'discount', 'tax', 'paid_amount', 'notes', 'items', 'sale_id', 'showCreateModal']);
        $this->sale_date = date('Y-m-d');
        $this->invoice_no = 'SALE-' . strtoupper(uniqid());
        $this->items = [
            ['product_id' => '', 'store_id' => '', 'quantity' => 1, 'unit_price' => 0]
        ];
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showCreateModal = true;
    }

    public function store()
    {
        $this->validate();

        // Check stock availability (FIFO validation)
        foreach ($this->items as $item) {
            $totalAvailable = Inventory::where('product_id', $item['product_id'])
                ->where('store_id', $item['store_id'])
                ->where('quantity', '>', 0)
                ->sum('quantity');
            
            if ($totalAvailable < $item['quantity']) {
                $product = Product::find($item['product_id']);
                session()->flash('error', "Not enough stock for {$product->name}. Available: {$totalAvailable}");
                return;
            }
        }

        DB::transaction(function () {
            $subtotal = 0;
            foreach ($this->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $total = $subtotal - $this->discount + $this->tax;
            $paymentStatus = 'unpaid';
            if ($this->paid_amount >= $total) {
                $paymentStatus = 'paid';
            } elseif ($this->paid_amount > 0) {
                $paymentStatus = 'partial';
            }

            $sale = Sale::create([
                'customer_id' => $this->customer_id,
                'invoice_no' => $this->invoice_no,
                'sale_date' => $this->sale_date,
                'subtotal' => $subtotal,
                'discount' => $this->discount,
                'tax' => $this->tax,
                'total' => $total,
                'paid_amount' => $this->paid_amount,
                'payment_status' => $paymentStatus,
                'notes' => $this->notes,
                'created_by' => auth()->id(),
            ]);

            foreach ($this->items as $itemData) {
                $remainingQtyToDeduct = $itemData['quantity'];
                
                // FIFO Selection: Pick batches with nearest expiry first
                $batches = Inventory::where('product_id', $itemData['product_id'])
                    ->where('store_id', $itemData['store_id'])
                    ->where('quantity', '>', 0)
                    ->orderBy('expiry_date', 'asc')
                    ->get();

                foreach ($batches as $batch) {
                    if ($remainingQtyToDeduct <= 0) break;

                    $deductFromBatch = min($batch->quantity, $remainingQtyToDeduct);
                    
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $itemData['product_id'],
                        'store_id' => $itemData['store_id'],
                        'batch_no' => $batch->batch_no,
                        'quantity' => $deductFromBatch,
                        'unit_price' => $itemData['unit_price'],
                        'total' => $deductFromBatch * $itemData['unit_price'],
                    ]);

                    $batch->decrement('quantity', $deductFromBatch);
                    $remainingQtyToDeduct -= $deductFromBatch;

                    // Record Stock Movement
                    $currentBalance = Inventory::where('product_id', $itemData['product_id'])->sum('quantity');
                    
                    StockMovement::create([
                        'product_id' => $itemData['product_id'],
                        'store_id' => $itemData['store_id'],
                        'type' => 'sale',
                        'reference_type' => Sale::class,
                        'reference_id' => $sale->id,
                        'batch_no' => $batch->batch_no,
                        'quantity_in' => 0,
                        'quantity_out' => $deductFromBatch,
                        'balance' => $currentBalance,
                        'notes' => 'Stock out via Sale #' . $this->invoice_no,
                        'created_by' => auth()->id(),
                    ]);
                }
            }
        });

        $this->dispatch('sale-saved', 'Sale recorded and stock deducted!');
        $this->resetFields();
    }

    public function delete($id)
    {
        $sale = Sale::findOrFail($id);
        
        DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                // Return stock to inventory
                $inventory = Inventory::where('store_id', $item->store_id)
                    ->where('product_id', $item->product_id)
                    ->where('batch_no', $item->batch_no)
                    ->first();
                
                if ($inventory) {
                    $inventory->increment('quantity', $item->quantity);
                } else {
                    // This batch was completely sold out and maybe its record was removed? 
                    // No, our schema keeps batches with 0 qty unless manually deleted.
                    Inventory::create([
                        'store_id' => $item->store_id,
                        'product_id' => $item->product_id,
                        'batch_no' => $item->batch_no,
                        'quantity' => $item->quantity,
                        'expiry_date' => now()->addYear(), // Fallback if lost, but it should exist
                    ]);
                }

                // Movement Record
                StockMovement::create([
                    'product_id' => $item->product_id,
                    'store_id' => $item->store_id,
                    'type' => 'adjustment',
                    'batch_no' => $item->batch_no,
                    'quantity_in' => $item->quantity,
                    'quantity_out' => 0,
                    'balance' => Inventory::where('product_id', $item->product_id)->sum('quantity'),
                    'notes' => 'Sale deletion #' . $sale->invoice_no,
                    'created_by' => auth()->id(),
                ]);
            }
            $sale->delete();
        });

        $this->dispatch('sale-deleted', 'Sale deleted and stock restored!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $sales = Sale::with(['customer', 'creator'])->latest()->get();
        $customers = Customer::all();
        $products = Product::where('status', 'active')->get();
        $stores = Store::where('status', 'active')->get();
        return view('livewire.admin.sales.sale-index', compact('sales', 'customers', 'products', 'stores'));
    }
}
