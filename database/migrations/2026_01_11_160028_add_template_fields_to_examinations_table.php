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
        Schema::table('examinations', function (Blueprint $table) {
            $table->text('history')->nullable();
            
            // Old RX
            $table->string('old_sphere_od')->nullable();
            $table->string('old_cyl_od')->nullable();
            $table->string('old_axis_od')->nullable();
            $table->string('old_add_od')->nullable();
            $table->string('old_va_od')->nullable();
            
            $table->string('old_sphere_os')->nullable();
            $table->string('old_cyl_os')->nullable();
            $table->string('old_axis_os')->nullable();
            $table->string('old_add_os')->nullable();
            $table->string('old_va_os')->nullable();
            
            // Subjective ref
            $table->string('subj_sphere_od')->nullable();
            $table->string('subj_cyl_od')->nullable();
            $table->string('subj_axis_od')->nullable();
            $table->string('subj_add_od')->nullable();
            $table->string('subj_va_od')->nullable();
            
            $table->string('subj_sphere_os')->nullable();
            $table->string('subj_cyl_os')->nullable();
            $table->string('subj_axis_os')->nullable();
            $table->string('subj_add_os')->nullable();
            $table->string('subj_va_os')->nullable();
            
            $table->string('specialist')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn([
                'history',
                'old_sphere_od', 'old_cyl_od', 'old_axis_od', 'old_add_od', 'old_va_od',
                'old_sphere_os', 'old_cyl_os', 'old_axis_os', 'old_add_os', 'old_va_os',
                'subj_sphere_od', 'subj_cyl_od', 'subj_axis_od', 'subj_add_od', 'subj_va_od',
                'subj_sphere_os', 'subj_cyl_os', 'subj_axis_os', 'subj_add_os', 'subj_va_os',
                'specialist'
            ]);
        });
    }
};
