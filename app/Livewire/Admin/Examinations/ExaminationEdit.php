<?php

namespace App\Livewire\Admin\Examinations;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ExaminationEdit extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.examinations.examination-edit');
    }
}
