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

class SaleCreate extends Component
{
    public $customer_id, $invoice_no, $sale_date, $discount = 0, $tax = 0, $paid_amount = 0, $notes;
    public $items = []; 

    public function mount()
    {
        $this->sale_date = date('Y-m-d');
        $this->invoice_no = 'SALE-' . strtoupper(uniqid());

        // Set first customer as default
        $defaultCustomer = Customer::first();
        if ($defaultCustomer) {
            $this->customer_id = $defaultCustomer->id;
        }

        // Set first store as default
        $firstStore = Store::where('status', 'active')->first();
        $storeId = $firstStore ? $firstStore->id : '';

        $this->items = [
            ['product_id' => '', 'store_id' => $storeId, 'product_name' => '', 'quantity' => 1, 'unit_price' => 0]
        ];

        $this->calculateTotals();
    }

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'invoice_no' => 'required|string|max:255|unique:sales,invoice_no',
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
        $firstStore = Store::where('status', 'active')->first();
        $storeId = $firstStore ? $firstStore->id : '';

        $this->items[] = ['product_id' => '', 'store_id' => $storeId, 'product_name' => '', 'quantity' => 1, 'unit_price' => 0];
        $this->dispatch('item-added');
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    // This will be called by Select2 bridge
    public function setProduct($index, $productId, $price)
    {
        $product = Product::find($productId);
        if ($product) {
            $this->items[$index]['product_id'] = $productId;
            $this->items[$index]['product_name'] = $product->name;
            $this->items[$index]['unit_price'] = $price;
            $this->calculateTotals();
        }
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
        $total = $subtotal - (float)$this->discount + (float)$this->tax;
        $this->paid_amount = max(0, $total);
    }

    public function setCustomer($customerId)
    {
        $this->customer_id = $customerId;
    }

    public function store()
    {
        $this->validate();

        // Check stock availability
        foreach ($this->items as $item) {
            $totalAvailable = Inventory::where('product_id', $item['product_id'])
                ->where('store_id', $item['store_id'])
                ->where('quantity', '>', 0)
                ->sum('quantity');
            
            if ($totalAvailable < $item['quantity']) {
                $product = Product::find($item['product_id']);
                session()->flash('error', "Not enough stock for {$product->name}. [Available: {$totalAvailable}]");
                return;
            }
        }

        $sale = DB::transaction(function () {
            $subtotal = collect($this->items)->sum(fn($i) => (float)($i['quantity'] ?? 0) * (float)($i['unit_price'] ?? 0));
            $total = $subtotal - (float)$this->discount + (float)$this->tax;
            
            $paymentStatus = 'unpaid';
            if ($this->paid_amount >= $total) $paymentStatus = 'paid';
            elseif ($this->paid_amount > 0) $paymentStatus = 'partial';

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

            return $sale;
        });

        session()->flash('success', 'Sale created successfully!');
        $this->dispatch('sale-completed', saleId: $sale->id);
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['discount', 'tax', 'paid_amount', 'notes']);
        $this->sale_date = date('Y-m-d');
        $this->invoice_no = 'SALE-' . strtoupper(uniqid());

        // Set first customer as default
        $defaultCustomer = Customer::first();
        if ($defaultCustomer) {
            $this->customer_id = $defaultCustomer->id;
        }

        // Set first store as default
        $firstStore = Store::where('status', 'active')->first();
        $storeId = $firstStore ? $firstStore->id : '';

        $this->items = [
            ['product_id' => '', 'store_id' => $storeId, 'product_name' => '', 'quantity' => 1, 'unit_price' => 0]
        ];

        $this->calculateTotals();
        $this->dispatch('form-reset');
    }

    public function regenerateInvoiceNo()
    {
        $this->invoice_no = 'SALE-' . strtoupper(uniqid());
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $stores = Store::where('status', 'active')->get();
        return view('livewire.admin.sales.sale-create', compact('stores'));
    }
}
