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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('examination_id')->nullable()->constrained()->onDelete('set null');
            
            // OD (Right Eye)
            $table->string('sphere_od')->nullable();
            $table->string('cyl_od')->nullable();
            $table->string('axis_od')->nullable();
            $table->string('add_od')->nullable();
            $table->string('va_od')->nullable();
            
            // OS (Left Eye)
            $table->string('sphere_os')->nullable();
            $table->string('cyl_os')->nullable();
            $table->string('axis_os')->nullable();
            $table->string('add_os')->nullable();
            $table->string('va_os')->nullable();
            
            $table->string('ipd')->nullable();
            $table->text('notes')->nullable();
            $table->string('specialist')->nullable();
            
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
        Schema::dropIfExists('prescriptions');
    }
};
