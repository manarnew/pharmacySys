<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            // Drop the old specialist string column
            $table->dropColumn('specialist');
            
            // Add the new specialist_id foreign key
            $table->foreignId('specialist_id')->nullable()->after('notes')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['specialist_id']);
            $table->dropColumn('specialist_id');
            
            // Restore the old specialist string column
            $table->string('specialist')->nullable();
        });
    }
};
