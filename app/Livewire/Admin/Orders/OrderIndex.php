<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

class OrderIndex extends Component
{
    public $patient_id;
    public $prescription_id;
    public $patient;
    public $prescription;

    public $invoice_no;
    public $frame_type;
    public $lens_index;
    public $lens_type;
    public $photo;
    public $package;
    public $destination = 'مصنع النور';
    public $notes;
    public $total_amount = 0;
    public $paid_amount = 0;
    public $discount = 0;
    public $balance = 0;

    protected $rules = [
        'total_amount' => 'required|numeric|min:0',
        'paid_amount' => 'required|numeric|min:0',
        'discount' => 'required|numeric|min:0',
    ];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['total_amount', 'paid_amount', 'discount'])) {
            $this->calculateBalance();
        }
    }

    public function calculateBalance()
    {
        $this->total_amount = floatval($this->total_amount);
        $this->paid_amount = floatval($this->paid_amount);
        $this->discount = floatval($this->discount);
        $this->balance = $this->total_amount - ($this->paid_amount + $this->discount);
    }

    public function mount()
    {
        $this->patient_id = request()->query('patient_id');
        $this->prescription_id = request()->query('prescription_id');

        if ($this->patient_id) {
            $this->patient = Patient::find($this->patient_id);
        }

        if ($this->prescription_id) {
            $this->prescription = Prescription::find($this->prescription_id);
            if ($this->prescription && !$this->patient) {
                $this->patient = $this->prescription->patient;
                $this->patient_id = $this->prescription->patient_id;
            }
        }

        // $this->invoice_no = 'INV-' . str_pad(Order::max('id') + 1, 6, '0', STR_PAD_LEFT);
        $this->invoice_no = '';
    }

    public function save()
    {
        $order = Order::create([
            'invoice_no' => $this->invoice_no,
            'patient_id' => $this->patient_id,
            'prescription_id' => $this->prescription_id,
            'frame_type' => $this->frame_type,
            'lens_index' => $this->lens_index,
            'lens_type' => $this->lens_type,
            'photo' => $this->photo,
            'package' => $this->package,
            'destination' => $this->destination,
            'notes' => $this->notes,
            'status' => 'pending',
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'discount' => $this->discount,
            'balance' => $this->balance,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.orders.show', ['order_id' => $order->id]);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $suppliers = Supplier::all();
        return view('livewire.admin.orders.order-index', compact('suppliers'));
    }

}
