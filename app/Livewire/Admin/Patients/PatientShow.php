<?php

namespace App\Livewire\Admin\Patients;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\Layout;

class PatientShow extends Component
{
    public $patient;

    public function mount()
    {
        $patient_id = request()->query('patient_id');
        $this->patient = Patient::with(['examinations.specialist', 'examinations.prescription.order'])
            ->findOrFail($patient_id);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.patients.patient-show');
    }
}

