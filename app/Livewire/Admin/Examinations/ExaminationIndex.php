<?php

namespace App\Livewire\Admin\Examinations;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ExaminationIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.examinations.examination-index');
    }

    public function save()
    {
        return redirect()->route('admin.examinations.edit');
    }
}
