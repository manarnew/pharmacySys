<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * FUTURE PHASE - Not required for initial implementation
     */
    public function up(): void
    {
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('restrict');
            $table->enum('type', ['in', 'out']);
            $table->enum('reason', ['petty_cash', 'supplier_payment', 'adjustment', 'other']);
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->string('reference_type')->nullable(); // Polymorphic
            $table->unsignedBigInteger('reference_id')->nullable(); // Polymorphic
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Indexes
            $table->index(['shift_id', 'type']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_movements');
    }
};
