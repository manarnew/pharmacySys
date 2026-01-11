<?php

namespace App\Livewire\Admin\Patients;

use Livewire\Component;

class PatientTable extends Component
{
    public function render()
    {
        return view('livewire.admin.patients.patient-table')
            ->layout('layouts.admin');
    }
}
