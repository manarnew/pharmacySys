<?php

namespace App\Livewire\Admin\Prescriptions;

use Livewire\Component;
use Livewire\Attributes\Layout;

class PrescriptionIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.prescriptions.prescription-index');
    }
}
