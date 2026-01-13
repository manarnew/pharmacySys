<?php

namespace App\Livewire\Admin\Patients;

use Livewire\Component;

use App\Models\Patient;
use Livewire\WithPagination;

class PatientTable extends Component
{
    use WithPagination;

    public $name, $phone, $age, $patient_id;
    public $isEditing = false;
    public $showConfirmDuplicate = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'age' => 'nullable|integer|min:0',
    ];

    public function resetFields()
    {
        $this->reset(['name', 'phone', 'age', 'patient_id', 'isEditing', 'showConfirmDuplicate']);
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function checkDuplicate()
    {
        $this->validate();

        $duplicate = Patient::where('name', $this->name)
            ->where('phone', $this->phone)
            ->first();

        if ($duplicate && !$this->showConfirmDuplicate) {
            $this->showConfirmDuplicate = true;
            return;
        }

        $this->store();
    }

    public function store()
    {
        Patient::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'age' => $this->age,
            'date' => now()->toDateString(),
            'created_by' => auth()->id(),
        ]);

        $this->dispatch('patient-saved', 'Patient saved successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        $this->patient_id = $id;
        $this->name = $patient->name;
        $this->phone = $patient->phone;
        $this->age = $patient->age;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        if ($this->patient_id) {
            $patient = Patient::findOrFail($this->patient_id);
            $patient->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'age' => $this->age,
                'updated_by' => auth()->id(),
            ]);

            $this->dispatch('patient-saved', 'Patient updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Patient::findOrFail($id)->delete();
        $this->dispatch('patient-deleted', 'Patient deleted successfully!');
    }

    public function render()
    {
        $patients = Patient::with(['creator', 'updater'])->latest()->get();
        return view('livewire.admin.patients.patient-table', compact('patients'))
            ->layout('layouts.admin');
    }
}
