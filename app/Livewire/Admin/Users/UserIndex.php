<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\Attributes\Layout;

class UserIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.users.user-index');
    }
}
