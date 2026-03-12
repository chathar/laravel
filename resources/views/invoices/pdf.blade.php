<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 40px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .title { font-size: 32px; font-weight: bold; color: #1e293b; text-transform: uppercase; }
        .details { margin-top: 20px; }
        .client-info { float: left; width: 50%; }
        .invoice-info { float: right; width: 40%; text-align: right; }
        .table { width: 100%; border-collapse: collapse; margin-top: 40px; }
        .table th { background: #f8fafc; border-bottom: 2px solid #eee; padding: 12px; text-align: left; font-size: 12px; text-transform: uppercase; color: #64748b; }
        .table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .totals { margin-top: 30px; float: right; width: 40%; }
        .totals-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
        .grand-total { font-size: 20px; font-weight: bold; color: #2563eb; padding-top: 15px; border-top: 2px solid #eee; margin-top: 10px; }
        .notes { margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; font-size: 12px; color: #64748b; }
        .clearfix { clear: both; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="title" style="float: left;">Invoice</div>
            <div style="float: right; text-align: right;">
                <h2 style="margin: 0;">Smart Invoice System</h2>
                <p style="font-size: 12px; color: #64748b; margin: 5px 0 0 0;">Building 123, Tech Park, Bangalore</p>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="details">
            <div class="client-info">
                <p style="font-size: 12px; font-weight: bold; text-transform: uppercase; color: #64748b; margin-bottom: 5px;">Billed To:</p>
                <h3 style="margin: 0;">{{ $invoice->client->name }}</h3>
                <p style="margin: 5px 0;">{{ $invoice->client->company }}</p>
                <p style="margin: 5px 0; font-size: 13px; color: #475569;">{!! nl2br(e($invoice->client->address)) !!}</p>
                @if($invoice->client->tax_number)
                    <p style="margin: 5px 0; font-size: 12px;">Tax ID: {{ $invoice->client->tax_number }}</p>
                @endif
            </div>
            <div class="invoice-info">
                <p style="margin: 5px 0;"><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
                <p style="margin: 5px 0;"><strong>Date:</strong> {{ $invoice->invoice_date->format('M d, Y') }}</p>
                <p style="margin: 5px 0;"><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
            </div>
            <div class="clearfix"></div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left; color: #64748b;">Subtotal</td>
                    <td style="text-align: right;">${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                @if($invoice->tax_amount > 0)
                <tr>
                    <td style="text-align: left; color: #64748b;">Tax ({{ $invoice->tax_rate }}%)</td>
                    <td style="text-align: right;">${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                @endif
                @if($invoice->discount_amount > 0)
                <tr>
                    <td style="text-align: left; color: #64748b;">Discount</td>
                    <td style="text-align: right; color: #e11d48;">-${{ number_format($invoice->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td style="text-align: left; font-weight: bold; font-size: 18px; padding-top: 10px;">Total</td>
                    <td style="text-align: right; font-weight: bold; font-size: 18px; padding-top: 10px; color: #2563eb;">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>

        @if($invoice->notes)
        <div class="notes">
            <p style="font-weight: bold; margin-bottom: 5px;">Notes:</p>
            <p style="margin: 0; font-style: italic;">{{ $invoice->notes }}</p>
        </div>
        @endif
    </div>
</body>
</html>
