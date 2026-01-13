<?php

namespace App\Livewire\Admin\Examinations;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Examination;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class ExaminationIndex extends Component
{
    public $patient_id;
    public $patient;
    
    public $history;
    

    // Old RX properties
    public $old_sphere_od, $old_cyl_od, $old_axis_od, $old_add_od, $old_va_od;
    public $old_sphere_os, $old_cyl_os, $old_axis_os, $old_add_os, $old_va_os;
    
    // Subjective RX properties
    public $subj_sphere_od, $subj_cyl_od, $subj_axis_od, $subj_add_od, $subj_va_od;
    public $subj_sphere_os, $subj_cyl_os, $subj_axis_os, $subj_add_os, $subj_va_os;

    public function mount()
    {
        $this->patient_id = request()->query('patient_id');
        
        if ($this->patient_id) {
            $this->patient = Patient::findOrFail($this->patient_id);
        } else {
            return redirect()->route('admin.patients.index')->with('error', 'Please select a patient first.');
        }
    }

    public function save()
    {
        $examination = Examination::create([
            'patient_id' => $this->patient_id,
            'history' => $this->history,
            'specialist_id' => Auth::id(),
            

            'old_sphere_od' => $this->old_sphere_od,
            'old_cyl_od' => $this->old_cyl_od,
            'old_axis_od' => $this->old_axis_od,
            'old_add_od' => $this->old_add_od,
            'old_va_od' => $this->old_va_od,
            
            'old_sphere_os' => $this->old_sphere_os,
            'old_cyl_os' => $this->old_cyl_os,
            'old_axis_os' => $this->old_axis_os,
            'old_add_os' => $this->old_add_os,
            'old_va_os' => $this->old_va_os,
            
            'subj_sphere_od' => $this->subj_sphere_od,
            'subj_cyl_od' => $this->subj_cyl_od,
            'subj_axis_od' => $this->subj_axis_od,
            'subj_add_od' => $this->subj_add_od,
            'subj_va_od' => $this->subj_va_od,
            
            'subj_sphere_os' => $this->subj_sphere_os,
            'subj_cyl_os' => $this->subj_cyl_os,
            'subj_axis_os' => $this->subj_axis_os,
            'subj_add_os' => $this->subj_add_os,
            'subj_va_os' => $this->subj_va_os,
            
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        session()->flash('success', 'Initial examination data saved. Please complete the measurements.');
        return redirect()->route('admin.examinations.edit', ['examination_id' => $examination->id]);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.examinations.examination-index');
    }
}
