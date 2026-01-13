<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_financial_fields_are_fillable()
    {
        $patient = Patient::create([
            'name' => 'John Doe',
            'phone' => '123456789'
        ]);

        $order = Order::create([
            'invoice_no' => 'INV-TEST-01',
            'patient_id' => $patient->id,
            'total_amount' => 1000,
            'paid_amount' => 400,
            'discount' => 100,
            'balance' => 500,
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('orders', [
            'invoice_no' => 'INV-TEST-01',
            'total_amount' => 1000,
            'paid_amount' => 400,
            'discount' => 100,
            'balance' => 500
        ]);
    }

    public function test_revenue_aggregation_in_dashboard_logic()
    {
        $patient = Patient::create(['name' => 'Test', 'phone' => '111']);
        
        Order::create(['invoice_no' => 'INV-1', 'patient_id' => $patient->id, 'paid_amount' => 500, 'balance' => 0, 'total_amount' => 500]);
        Order::create(['invoice_no' => 'INV-2', 'patient_id' => $patient->id, 'paid_amount' => 300, 'balance' => 200, 'total_amount' => 500]);

        $totalRevenue = Order::sum('paid_amount');
        $this->assertEquals(800, $totalRevenue);

        $totalBalance = Order::sum('balance');
        $this->assertEquals(200, $totalBalance);
    }
}
