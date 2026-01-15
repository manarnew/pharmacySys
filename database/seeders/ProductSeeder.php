<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        $products = [
            [
                'name' => 'Amoxicillin 500mg',
                'sku' => '6221234567890',
                'generic_name' => 'Amoxicillin',
                'category_id' => $categories->where('name', 'Antibiotics')->first()?->id,
                'unit' => 'box',
                'purchase_price' => 10.00,
                'selling_price' => 15.00,
                'tax_rate' => 5.00,
                'reorder_level' => 20,
                'is_prescription_required' => true,
                'status' => 'active',
                'description' => 'Used for bacterial infections.',
            ],
            [
                'name' => 'Panadol Advance 500mg',
                'sku' => '6229876543210',
                'generic_name' => 'Paracetamol',
                'category_id' => $categories->where('name', 'Analgesics')->first()?->id,
                'unit' => 'box',
                'purchase_price' => 2.50,
                'selling_price' => 4.00,
                'tax_rate' => 0.00,
                'reorder_level' => 50,
                'is_prescription_required' => false,
                'status' => 'active',
                'description' => 'Fast and effective pain relief.',
            ],
            [
                'name' => 'Vitamin C 1000mg',
                'sku' => '6221111111111',
                'generic_name' => 'Ascorbic Acid',
                'category_id' => $categories->where('name', 'Vitamins & Supplements')->first()?->id,
                'unit' => 'bottle',
                'purchase_price' => 5.00,
                'selling_price' => 8.50,
                'tax_rate' => 0.00,
                'reorder_level' => 30,
                'is_prescription_required' => false,
                'status' => 'active',
                'description' => 'Boosts immunity.',
            ],
            [
                'name' => 'Advil 200mg',
                'sku' => '6222222222222',
                'generic_name' => 'Ibuprofen',
                'category_id' => $categories->where('name', 'Analgesics')->first()?->id,
                'unit' => 'box',
                'purchase_price' => 3.00,
                'selling_price' => 5.50,
                'tax_rate' => 5.00,
                'reorder_level' => 25,
                'is_prescription_required' => false,
                'status' => 'active',
                'description' => 'For inflammation and pain.',
            ],
            [
                'name' => 'Cravit 500mg',
                'sku' => '6223333333333',
                'generic_name' => 'Levofloxacin',
                'category_id' => $categories->where('name', 'Antibiotics')->first()?->id,
                'unit' => 'box',
                'purchase_price' => 25.00,
                'selling_price' => 35.00,
                'tax_rate' => 5.00,
                'reorder_level' => 10,
                'is_prescription_required' => true,
                'status' => 'active',
                'description' => 'Broad-spectrum antibiotic.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
