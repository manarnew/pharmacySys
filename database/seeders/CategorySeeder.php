<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Antibiotics', 'description' => 'Medicines that destroy or slow down the growth of bacteria.'],
            ['name' => 'Analgesics', 'description' => 'Medicines used to achieve relief from pain.'],
            ['name' => 'Antipyretics', 'description' => 'Medicines used to prevent or reduce fever.'],
            ['name' => 'Antivirals', 'description' => 'Medicines used specifically for treating viral infections.'],
            ['name' => 'Vitamins & Supplements', 'description' => 'Nutritional substances added to the diet.'],
            ['name' => 'First Aid', 'description' => 'Emergency care or treatment given to an ill or injured person.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
