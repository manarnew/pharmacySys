<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Patient;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $search = '';
    public $results = [];
    public $showResults = false;

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->showResults = true;
        $searchTerm = '%' . $this->search . '%';

        // Search patients by name or phone
        $patients = Patient::where('name', 'like', $searchTerm)
            ->orWhere('phone', 'like', $searchTerm)
            ->limit(5)
            ->get()
            ->map(function ($patient) {
                return [
                    'type' => 'patient',
                    'id' => $patient->id,
                    'title' => $patient->name,
                    'subtitle' => $patient->phone,
                    'url' => route('admin.patients.show', ['patient_id' => $patient->id])
                ];
            });

        // Search orders by invoice number
        $orders = Order::where('invoice_no', 'like', $searchTerm)
            ->with('patient')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'type' => 'order',
                    'id' => $order->id,
                    'title' => $order->invoice_no,
                    'subtitle' => $order->patient->name ?? 'N/A',
                    'url' => route('admin.orders.show', ['order_id' => $order->id])
                ];
            });

        $this->results = $patients->concat($orders)->toArray();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->results = [];
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.admin.global-search');
    }
}
