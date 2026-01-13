<?php

namespace App\Livewire\Admin\Prescriptions;

use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PrescriptionShow extends Component
{
    public $prescription;
    public $patient;

    public function mount()
    {
        $prescription_id = request()->query('prescription_id');
        if ($prescription_id) {
            $this->prescription = Prescription::with(['patient', 'specialist'])->find($prescription_id);

            if ($this->prescription) {
                $this->patient = $this->prescription->patient;
            }
        }
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.prescriptions.prescription-show');
    }
}
