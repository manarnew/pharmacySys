<?php

namespace App\Livewire\Admin\Branches;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Branch;
use Livewire\WithPagination;

class BranchIndex extends Component
{
    use WithPagination;

    public $name, $branch_id;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:branchs,name',
    ];

    public function resetFields()
    {
        $this->reset(['name', 'branch_id', 'isEditing']);
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function store()
    {
        $this->validate();

        Branch::create([
            'name' => $this->name,
        ]);

        $this->dispatch('branch-saved', 'Branch created successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $this->branch_id = $id;
        $this->name = $branch->name;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:branchs,name,' . $this->branch_id,
        ]);

        if ($this->branch_id) {
            $branch = Branch::findOrFail($this->branch_id);
            $branch->update([
                'name' => $this->name,
            ]);

            $this->dispatch('branch-saved', 'Branch updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Branch::findOrFail($id)->delete();
        $this->dispatch('branch-deleted', 'Branch deleted successfully!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $branchs = Branch::latest()->get();
        return view('livewire.admin.branches.branch-index', compact('branchs'));
    }
}
