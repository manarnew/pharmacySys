<?php

namespace App\Livewire\Admin\Examinations;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Examination;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;

class ExaminationEdit extends Component
{
    public $examination_id;
    public $examination;
    public $patient_id;
    public $patient;
    
    // Form fields (for potential future use, though non-editable here)
    public $sphere_rd, $cylinder_rd, $axis_rd, $va_rd;
    public $sphere_ld, $cylinder_ld, $axis_ld, $va_ld;
    public $sphere_rn, $cylinder_rn, $axis_rn, $va_rn;
    public $sphere_ln, $cylinder_ln, $axis_ln, $va_ln;
    public $pd, $notes;

    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
    ];

    public function mount()
    {
        $this->examination_id = request()->query('examination_id');
        $this->patient_id = request()->query('patient_id');
        
        if ($this->examination_id) {
            $this->examination = Examination::with('specialist')->findOrFail($this->examination_id);

            $this->patient_id = $this->examination->patient_id;
            $this->patient = $this->examination->patient;
            
            // Detailed fields
            $this->sphere_rd = $this->examination->sphere_rd;
            $this->cylinder_rd = $this->examination->cylinder_rd;
            $this->axis_rd = $this->examination->axis_rd;
            $this->va_rd = $this->examination->va_rd;
            
            $this->sphere_ld = $this->examination->sphere_ld;
            $this->cylinder_ld = $this->examination->cylinder_ld;
            $this->axis_ld = $this->examination->axis_ld;
            $this->va_ld = $this->examination->va_ld;
            
            $this->sphere_rn = $this->examination->sphere_rn;
            $this->cylinder_rn = $this->examination->cylinder_rn;
            $this->axis_rn = $this->examination->axis_rn;
            $this->va_rn = $this->examination->va_rn;
            
            $this->sphere_ln = $this->examination->sphere_ln;
            $this->cylinder_ln = $this->examination->cylinder_ln;
            $this->axis_ln = $this->examination->axis_ln;
            $this->va_ln = $this->examination->va_ln;
            
            $this->pd = $this->examination->pd;
            $this->notes = $this->examination->notes;
        } elseif ($this->patient_id) {
            $this->patient = Patient::findOrFail($this->patient_id);
        } else {
            return redirect()->route('admin.patients.index')->with('error', 'Please select a patient first.');
        }
    }

    public function convertToPrescription($source = 'subjective')
    {
        if (!$this->examination) {
            return;
        }

        $prefix = $source === 'old_rx' ? 'old_' : 'subj_';

        $prescription = Prescription::create([
            'patient_id' => $this->patient_id,
            'examination_id' => $this->examination_id,
            'sphere_od' => $this->examination->{$prefix . 'sphere_od'},
            'cyl_od' => $this->examination->{$prefix . 'cyl_od'},
            'axis_od' => $this->examination->{$prefix . 'axis_od'},
            'add_od' => $this->examination->{$prefix . 'add_od'},
            'va_od' => $this->examination->{$prefix . 'va_od'},
            'sphere_os' => $this->examination->{$prefix . 'sphere_os'},
            'cyl_os' => $this->examination->{$prefix . 'cyl_os'},
            'axis_os' => $this->examination->{$prefix . 'axis_os'},
            'add_os' => $this->examination->{$prefix . 'add_os'},
            'va_os' => $this->examination->{$prefix . 'va_os'},
            'ipd' => $this->examination->pd,
            'specialist_id' => $this->examination->specialist_id,

            'notes' => $this->examination->notes,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.prescriptions.index', ['prescription_id' => $prescription->id]);
    }

    public function save()
    {
        // No edit will be done here as per user request
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.examinations.examination-edit');
    }
}
