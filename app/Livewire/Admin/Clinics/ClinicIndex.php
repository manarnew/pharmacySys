<?php

namespace App\Livewire\Admin\Clinics;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Clinic;
use Livewire\WithPagination;

class ClinicIndex extends Component
{
    use WithPagination;

    public $name, $clinic_id;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:clinics,name',
    ];

    public function resetFields()
    {
        $this->reset(['name', 'clinic_id', 'isEditing']);
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function store()
    {
        $this->validate();

        Clinic::create([
            'name' => $this->name,
        ]);

        $this->dispatch('clinic-saved', 'Clinic created successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $clinic = Clinic::findOrFail($id);
        $this->clinic_id = $id;
        $this->name = $clinic->name;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:clinics,name,' . $this->clinic_id,
        ]);

        if ($this->clinic_id) {
            $clinic = Clinic::findOrFail($this->clinic_id);
            $clinic->update([
                'name' => $this->name,
            ]);

            $this->dispatch('clinic-saved', 'Clinic updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Clinic::findOrFail($id)->delete();
        $this->dispatch('clinic-deleted', 'Clinic deleted successfully!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $clinics = Clinic::latest()->get();
        return view('livewire.admin.clinics.clinic-index', compact('clinics'));
    }
}
