<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $sale->invoice_no }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .invoice-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #ddd; padding: 8px; text-align: left; }
        .totals { margin-top: 20px; text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="no-print" style="background: #fdf6e3; padding: 10px; margin-bottom: 20px; border: 1px solid #eee;">
        <button onclick="window.print()">Print Again</button>
        <button onclick="window.close()">Close Window</button>
    </div>

    <div class="header">
        <h2>PHARMACY SYSTEM</h2>
        <p>Your Health is Our Priority</p>
    </div>

    <div class="invoice-info">
        <p><strong>Invoice No:</strong> {{ $sale->invoice_no }}</p>
        <p><strong>Date:</strong> {{ $sale->sale_date->format('Y-m-d') }}</p>
        <p><strong>Customer:</strong> {{ $sale->customer->name ?? 'Walk-in' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }}</td>
                <td>{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>Subtotal: ${{ number_format($sale->subtotal, 2) }}</p>
        <p>Discount: ${{ number_format($sale->discount, 2) }}</p>
        <p>Tax: ${{ number_format($sale->tax, 2) }}</p>
        <p><strong>Total: ${{ number_format($sale->total, 2) }}</strong></p>
        <p>Paid: ${{ number_format($sale->paid_amount, 2) }}</p>
        <p>Balance: ${{ number_format($sale->total - $sale->paid_amount, 2) }}</p>
    </div>

    <div class="header" style="margin-top: 40px;">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>
