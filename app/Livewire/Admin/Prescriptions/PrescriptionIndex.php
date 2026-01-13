<?php

namespace App\Livewire\Admin\Prescriptions;

use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PrescriptionIndex extends Component
{
    public $prescription;
    public $patient;
    public $prescription_id;

    // Measurement properties
    public $sphere_od, $cyl_od, $axis_od, $add_od, $va_od;
    public $sphere_os, $cyl_os, $axis_os, $add_os, $va_os;
    public $ipd, $notes, $specialist;

    public function mount()
    {
        $this->prescription_id = request()->query('prescription_id');
        if ($this->prescription_id) {
            $this->prescription = Prescription::with(['patient', 'specialist'])->find($this->prescription_id);

            if ($this->prescription) {
                $this->patient = $this->prescription->patient;
                $this->loadData();
            }
        }
    }

    public function loadData()
    {
        $this->sphere_od = $this->prescription->sphere_od;
        $this->cyl_od = $this->prescription->cyl_od;
        $this->axis_od = $this->prescription->axis_od;
        $this->add_od = $this->prescription->add_od;
        $this->va_od = $this->prescription->va_od;

        $this->sphere_os = $this->prescription->sphere_os;
        $this->cyl_os = $this->prescription->cyl_os;
        $this->axis_os = $this->prescription->axis_os;
        $this->add_os = $this->prescription->add_os;
        $this->va_os = $this->prescription->va_os;

        $this->ipd = $this->prescription->ipd;
        $this->notes = $this->prescription->notes;

    }

    public function save()
    {
        if ($this->prescription) {
            $this->prescription->update([
                'sphere_od' => $this->sphere_od,
                'cyl_od' => $this->cyl_od,
                'axis_od' => $this->axis_od,
                'add_od' => $this->add_od,
                'va_od' => $this->va_od,
                'sphere_os' => $this->sphere_os,
                'cyl_os' => $this->cyl_os,
                'axis_os' => $this->axis_os,
                'add_os' => $this->add_os,
                'va_os' => $this->va_os,
                'ipd' => $this->ipd,
                'notes' => $this->notes,
                'updated_by' => Auth::id(),

            ]);
            session()->flash('success', 'Prescription saved successfully.');
            return redirect()->route('admin.prescriptions.show', ['prescription_id' => $this->prescription->id]);
        }
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.prescriptions.prescription-index');
    }
}
