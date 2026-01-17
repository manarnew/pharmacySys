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
        // Logo will be stored as a setting key-value pair
        // No schema change needed, just add the logo setting
        \App\Models\Setting::updateOrCreate(
            ['key' => 'logo'],
            ['value' => null]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Setting::where('key', 'logo')->delete();
    }
};
