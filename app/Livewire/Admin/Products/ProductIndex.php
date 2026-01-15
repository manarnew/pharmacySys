<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class ProductIndex extends Component
{
    use WithPagination;

    public $name, $sku, $generic_name, $category_id, $unit = 'piece', $purchase_price = 0, $selling_price = 0, $tax_rate = 0, $reorder_level = 10, $is_prescription_required = false, $status = 'active', $description;
    public $product_id;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'sku' => ['required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($this->product_id)],
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'unit' => 'required|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'reorder_level' => 'required|integer|min:0',
            'is_prescription_required' => 'boolean',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    public function resetFields()
    {
        $this->reset(['name', 'sku', 'generic_name', 'category_id', 'unit', 'purchase_price', 'selling_price', 'tax_rate', 'reorder_level', 'is_prescription_required', 'status', 'description', 'product_id', 'isEditing']);
        $this->unit = 'piece';
        $this->status = 'active';
        $this->purchase_price = 0;
        $this->selling_price = 0;
        $this->tax_rate = 0;
        $this->reorder_level = 10;
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function store()
    {
        $this->validate();

        Product::create([
            'sku' => $this->sku,
            'name' => $this->name,
            'generic_name' => $this->generic_name,
            'category_id' => $this->category_id,
            'unit' => $this->unit,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'tax_rate' => $this->tax_rate,
            'reorder_level' => $this->reorder_level,
            'is_prescription_required' => $this->is_prescription_required,
            'status' => $this->status,
            'description' => $this->description,
        ]);

        $this->dispatch('product-saved', 'Product created successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        $this->sku = $product->sku;
        $this->name = $product->name;
        $this->generic_name = $product->generic_name;
        $this->category_id = $product->category_id;
        $this->unit = $product->unit;
        $this->purchase_price = $product->purchase_price;
        $this->selling_price = $product->selling_price;
        $this->tax_rate = $product->tax_rate;
        $this->reorder_level = $product->reorder_level;
        $this->is_prescription_required = $product->is_prescription_required;
        $this->status = $product->status;
        $this->description = $product->description;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        if ($this->product_id) {
            $product = Product::findOrFail($this->product_id);
            $product->update([
                'sku' => $this->sku,
                'name' => $this->name,
                'generic_name' => $this->generic_name,
                'category_id' => $this->category_id,
                'unit' => $this->unit,
                'purchase_price' => $this->purchase_price,
                'selling_price' => $this->selling_price,
                'tax_rate' => $this->tax_rate,
                'reorder_level' => $this->reorder_level,
                'is_prescription_required' => $this->is_prescription_required,
                'status' => $this->status,
                'description' => $this->description,
            ]);

            $this->dispatch('product-saved', 'Product updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        $this->dispatch('product-deleted', 'Product deleted successfully!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $products = Product::with('category')->latest()->get();
        return view('livewire.admin.products.product-index', compact('products'));
    }
}
