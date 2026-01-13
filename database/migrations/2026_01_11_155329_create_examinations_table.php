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
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            
            // Distance (D)
            $table->string('sphere_rd')->nullable();
            $table->string('cylinder_rd')->nullable();
            $table->string('axis_rd')->nullable();
            $table->string('va_rd')->nullable();
            
            $table->string('sphere_ld')->nullable();
            $table->string('cylinder_ld')->nullable();
            $table->string('axis_ld')->nullable();
            $table->string('va_ld')->nullable();
            
            // Near (N)
            $table->string('sphere_rn')->nullable();
            $table->string('cylinder_rn')->nullable();
            $table->string('axis_rn')->nullable();
            $table->string('va_rn')->nullable();
            
            $table->string('sphere_ln')->nullable();
            $table->string('cylinder_ln')->nullable();
            $table->string('axis_ln')->nullable();
            $table->string('va_ln')->nullable();
            
            $table->string('pd')->nullable();
            $table->text('notes')->nullable();
            
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
