<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice - {{ $sale->invoice_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 15px; }
        .logo { max-width: 80px; max-height: 80px; margin: 0 auto 10px; }
        .invoice-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; font-size: 1.2em; }
        .text-right { text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print();">
    @php
        $siteSettings = \App\Models\Setting::pluck('value', 'key');
    @endphp
    
    <div class="no-print" style="background: #fdf6e3; padding: 10px; margin-bottom: 20px; border: 1px solid #eee;">
        <button onclick="window.print()">Print Again</button>
        <button onclick="window.close()">Close Window</button>
    </div>

    <div class="header">
        <p>{{ $site_settings['site_description'] ?? 'Your Health is Our Priority' }}</p>
        @if(isset($site_settings['address'])) <p>{{ $site_settings['address'] }}</p> @endif
        @if(isset($site_settings['phone'])) <p>Tel: {{ $site_settings['phone'] }}</p> @endif
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
        <p>{{ __('Subtotal') }}: ${{ number_format($sale->subtotal, 2) }}</p>
        <p>{{ __('Discount') }}: ${{ number_format($sale->discount, 2) }}</p>
        <p>{{ __('Tax') }}: ${{ number_format($sale->tax, 2) }}</p>
        <p><strong>{{ __('Total') }}: ${{ number_format($sale->total, 2) }}</strong></p>
        <p>{{ __('Paid') }}: ${{ number_format($sale->paid_amount, 2) }}</p>
        
        @if($sale->payment_type === 'cash_bankak')
            <p> - {{ __('Cash') }}: ${{ number_format($sale->cash_amount, 2) }}</p>
            <p> - {{ __('Bankak') }}: ${{ number_format($sale->bankak_amount, 2) }}</p>
        @endif

        @if($sale->transaction_number)
            <p><strong>{{ __('TRN') }}:</strong> {{ $sale->transaction_number }}</p>
        @endif
        @if($sale->sender_name)
            <p><strong>{{ __('Sender') }}:</strong> {{ $sale->sender_name }}</p>
        @endif
        
        <p>{{ __('Balance') }}: ${{ number_format($sale->total - $sale->paid_amount, 2) }}</p>
    </div>

    <div class="header" style="margin-top: 40px;">
        <p>{{ $site_settings['footer_text'] ?? 'Thank you for your business!' }}</p>
    </div>
</body>
</html>
