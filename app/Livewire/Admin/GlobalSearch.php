<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Supplier;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $search = '';
    public $results = [];
    public $showResults = false;

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->showResults = true;
        $searchTerm = '%' . $this->search . '%';

        // Search customers by name or phone
        $customers = Customer::where('name', 'like', $searchTerm)
            ->orWhere('phone', 'like', $searchTerm)
            ->limit(5)
            ->get()
            ->map(function ($customer) {
                return [
                    'type' => 'customer',
                    'id' => $customer->id,
                    'title' => $customer->name,
                    'subtitle' => $customer->phone,
                    'url' => route('admin.customers.show', ['customer_id' => $customer->id])
                ];
            });

        // Search suppliers
        $suppliers = Supplier::where('name', 'like', $searchTerm)
            ->orWhere('phone', 'like', $searchTerm)
            ->limit(5)
            ->get()
            ->map(function ($supplier) {
                return [
                    'type' => 'supplier',
                    'id' => $supplier->id,
                    'title' => $supplier->name,
                    'subtitle' => $supplier->phone,
                    'url' => route('admin.suppliers.index')
                ];
            });

        // Search products
        $products = \App\Models\Product::where('name', 'like', $searchTerm)
            ->orWhere('sku', 'like', $searchTerm)
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'type' => 'product',
                    'id' => $product->id,
                    'title' => $product->name,
                    'subtitle' => 'SKU: ' . $product->sku,
                    'url' => route('admin.products.index')
                ];
            });

        // Search sales
        $sales = \App\Models\Sale::where('invoice_no', 'like', $searchTerm)
            ->limit(3)
            ->get()
            ->map(function ($sale) {
                return [
                    'type' => 'sale',
                    'id' => $sale->id,
                    'title' => 'Sale #' . $sale->invoice_no,
                    'subtitle' => 'Total: $' . number_format($sale->total, 2),
                    'url' => route('admin.sales.index')
                ];
            });

        // Search purchases
        $purchases = \App\Models\Purchase::where('invoice_no', 'like', $searchTerm)
            ->limit(3)
            ->get()
            ->map(function ($purchase) {
                return [
                    'type' => 'purchase',
                    'id' => $purchase->id,
                    'title' => 'Purchase #' . $purchase->invoice_no,
                    'subtitle' => 'Total: $' . number_format($purchase->total, 2),
                    'url' => route('admin.purchases.index')
                ];
            });

        $this->results = $customers->concat($suppliers)
            ->concat($products)
            ->concat($sales)
            ->concat($purchases)
            ->toArray();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->results = [];
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.admin.global-search');
    }
}
