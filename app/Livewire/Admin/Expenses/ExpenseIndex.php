<?php

namespace App\Livewire\Admin\Expenses;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Expense;
use Livewire\WithPagination;

class ExpenseIndex extends Component
{
    use WithPagination;

    public $reason, $amount, $date, $expense_id;
    public $isEditing = false;

    protected $rules = [
        'reason' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
    ];

    public function resetFields()
    {
        $this->reset(['reason', 'amount', 'date', 'expense_id', 'isEditing']);
    }

    public function openModal()
    {
        $this->resetFields();
        $this->date = now()->toDateString();
    }

    public function store()
    {
        $this->validate();

        Expense::create([
            'reason' => $this->reason,
            'amount' => $this->amount,
            'date' => $this->date,
        ]);

        $this->dispatch('expense-saved', 'Expense added successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $this->expense_id = $id;
        $this->reason = $expense->reason;
        $this->amount = $expense->amount;
        $this->date = $expense->date;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        if ($this->expense_id) {
            $expense = Expense::findOrFail($this->expense_id);
            $expense->update([
                'reason' => $this->reason,
                'amount' => $this->amount,
                'date' => $this->date,
            ]);

            $this->dispatch('expense-saved', 'Expense updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Expense::findOrFail($id)->delete();
        $this->dispatch('expense-deleted', 'Expense deleted successfully!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $expenses = Expense::latest()->get();
        return view('livewire.admin.expenses.expense-index', compact('expenses'));
    }
}
