<?php

namespace App\Livewire\Admin\Messages;

use Livewire\Component;
use Livewire\Attributes\Layout;

class MessageIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.messages.message-index');
    }
}
