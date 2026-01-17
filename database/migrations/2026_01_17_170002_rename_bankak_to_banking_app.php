<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing data first
        DB::table('sales')
            ->where('payment_type', 'bankak')
            ->update(['payment_type' => 'banking_app']);
        
        DB::table('sales')
            ->where('payment_type', 'cash_bankak')
            ->update(['payment_type' => 'cash_banking_app']);

        // Rename column
        Schema::table('sales', function (Blueprint $table) {
            $table->renameColumn('bankak_amount', 'banking_app_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert data
        DB::table('sales')
            ->where('payment_type', 'banking_app')
            ->update(['payment_type' => 'bankak']);
        
        DB::table('sales')
            ->where('payment_type', 'cash_banking_app')
            ->update(['payment_type' => 'cash_bankak']);

        // Rename column back
        Schema::table('sales', function (Blueprint $table) {
            $table->renameColumn('banking_app_amount', 'bankak_amount');
        });
    }
};
