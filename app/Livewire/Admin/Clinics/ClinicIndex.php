<?php

namespace App\Livewire\Admin\Clinics;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ClinicIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.clinics.clinic-index');
    }
}
