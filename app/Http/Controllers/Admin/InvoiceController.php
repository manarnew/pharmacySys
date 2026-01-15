<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function print(Sale $sale)
    {
        $sale->load(['customer', 'items.product', 'creator']);
        return view('admin.invoices.print', compact('sale'));
    }
}
