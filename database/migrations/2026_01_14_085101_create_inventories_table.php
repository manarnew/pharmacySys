<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('batch_no');
            $table->date('expiry_date');
            $table->integer('quantity')->default(0);
            $table->timestamps();
            
            // Unique constraint: one batch per product per store
            $table->unique(['store_id', 'product_id', 'batch_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
