<?php

namespace App\Livewire\Admin\Patients;

use Livewire\Component;
use Livewire\Attributes\Layout;

class PatientShow extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.patients.patient-show');
    }
}
