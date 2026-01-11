<?php

namespace App\Livewire\Admin\Expenses;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ExpenseIndex extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.expenses.expense-index');
    }
}
