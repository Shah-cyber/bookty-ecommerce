<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        @page { 
            margin: 20mm 15mm; 
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body { 
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif; 
            color: #1f2937; 
            font-size: 11px; 
            line-height: 1.5;
            background: #fff;
        }
        
        /* Layout Utilities */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .muted { color: #6b7280; }
        .bold { font-weight: 700; }
        .uppercase { text-transform: uppercase; }
        
        /* Typography */
        .h1 { font-size: 28px; font-weight: 700; color: #111827; letter-spacing: -0.5px; }
        .h2 { font-size: 16px; font-weight: 700; color: #111827; }
        .h3 { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .text-sm { font-size: 10px; }
        .text-xs { font-size: 9px; }
        .text-lg { font-size: 14px; }
        .text-xl { font-size: 18px; }
        
        /* Spacing */
        .section { margin-bottom: 20px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
        .py-2 { padding-top: 8px; padding-bottom: 8px; }
        .py-3 { padding-top: 12px; padding-bottom: 12px; }
        
        /* Grid Layout */
        .header-row {
            width: 100%;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        .header-row::after {
            content: "";
            display: table;
            clear: both;
        }
        .header-left { float: left; width: 50%; }
        .header-right { float: right; width: 50%; text-align: right; }
        
        .info-row {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-row::after {
            content: "";
            display: table;
            clear: both;
        }
        .info-col { float: left; width: 48%; }
        .info-col:last-child { float: right; }
        
        /* Box Styles */
        .box { 
            background: #f9fafb; 
            border: 1px solid #e5e7eb; 
            padding: 14px; 
            border-radius: 8px; 
        }
        
        /* Table Styles */
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th { 
            background: #f3f4f6; 
            color: #374151; 
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase; 
            letter-spacing: 0.3px;
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        td { 
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }
        tbody tr:last-child td {
            border-bottom: 1px solid #e5e7eb;
        }
        
        /* Totals Section */
        .totals-row {
            width: 100%;
        }
        .totals-row::after {
            content: "";
            display: table;
            clear: both;
        }
        .totals-spacer { float: left; width: 55%; }
        .totals-box { float: right; width: 45%; }
        .totals-inner {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
        }
        .totals-line {
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .totals-line:last-child {
            border-bottom: none;
            padding-top: 10px;
        }
        .totals-line::after {
            content: "";
            display: table;
            clear: both;
        }
        .totals-label { float: left; }
        .totals-value { float: right; font-weight: 600; }
        
        /* Badge */
        .badge { 
            display: inline-block; 
            padding: 3px 8px; 
            border-radius: 12px; 
            font-size: 9px;
            font-weight: 600;
        }
        .badge-success { background: #d1fae5; color: #047857; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        
        /* Footer */
        .footer { 
            position: fixed; 
            bottom: -10mm; 
            left: 0; 
            right: 0; 
            text-align: center; 
            font-size: 9px; 
            color: #9ca3af;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
        }
        
        /* Colors */
        .text-green { color: #059669; }
        .text-gray { color: #6b7280; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header-row">
        <div class="header-left">
            <div class="h1 mb-2">INVOICE</div>
            <div class="text-sm muted mb-1">Invoice No: <span class="bold" style="color: #111827;">{{ $invoiceNumber }}</span></div>
            <div class="text-sm muted mb-1">Date: <span class="bold" style="color: #111827;">{{ $order->created_at->format('d M Y') }}</span></div>
            <div class="text-sm muted">Order Ref: <span class="bold" style="color: #111827;">#{{ $order->public_id ?? $order->id }}</span></div>
        </div>
        <div class="header-right">
            <div class="h2 mb-2">{{ $seller['company'] }}</div>
            <div class="text-sm muted mb-1">{{ $seller['address'] }}</div>
            <div class="text-sm muted mb-1">Tax No: {{ $seller['tax_number'] }}</div>
            <div class="text-sm muted mb-1">{{ $seller['email'] }}</div>
            <div class="text-sm muted">{{ $seller['phone'] }}</div>
        </div>
    </div>

    {{-- Bill To & Payment Info --}}
    <div class="info-row">
        <div class="info-col">
            <div class="box">
                <div class="h3">Bill To</div>
                <div class="bold mb-1">{{ $order->user->name }}</div>
                <div class="text-sm muted mb-2">{{ $order->user->email }}</div>
                <div class="text-sm mt-2">{{ $order->shipping_address }}</div>
                <div class="text-sm">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</div>
                <div class="text-sm muted mt-2">Phone: {{ $order->shipping_phone }}</div>
            </div>
        </div>
        <div class="info-col">
            <div class="box">
                <div class="h3">Payment Information</div>
                <table style="width: 100%;">
                    <tr>
                        <td style="border: none; padding: 4px 0; width: 50%;" class="text-sm muted">Payment Status</td>
                        <td style="border: none; padding: 4px 0; text-align: right;">
                            <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 4px 0;" class="text-sm muted">Order Status</td>
                        <td style="border: none; padding: 4px 0; text-align: right;" class="text-sm bold">{{ ucfirst($order->status) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="section">
        <div class="h3 mb-3">Order Items</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 6%; text-align: left;">#</th>
                    <th style="text-align: left;">Item Description</th>
                    <th style="width: 10%; text-align: right;">Qty</th>
                    <th style="width: 18%; text-align: right;">Unit Price</th>
                    <th style="width: 18%; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $idx => $item)
                <tr>
                    <td class="text-sm muted">{{ $idx + 1 }}</td>
                    <td>
                        <div class="bold">{{ $item->book->title }}</div>
                        <div class="text-xs muted mt-1">by {{ $item->book->author }}</div>
                    </td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">RM {{ number_format($item->price, 2) }}</td>
                    <td class="text-right bold">RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Totals --}}
    <div class="totals-row">
        <div class="totals-spacer"></div>
        <div class="totals-box">
            <div class="totals-inner">
                <div class="totals-line">
                    <span class="totals-label text-sm muted">Subtotal</span>
                    <span class="totals-value text-sm">RM {{ number_format($subTotal, 2) }}</span>
                </div>
                @if($discount > 0)
                <div class="totals-line">
                    <span class="totals-label text-sm muted">Discount</span>
                    <span class="totals-value text-sm text-green">- RM {{ number_format($discount, 2) }}</span>
                </div>
                @endif
                <div class="totals-line">
                    <span class="totals-label text-sm muted">Shipping</span>
                    <span class="totals-value text-sm {{ $shippingCost == 0 ? 'text-green' : '' }}">
                        @if($shippingCost == 0)
                            Free
                        @else
                            RM {{ number_format($shippingCost, 2) }}
                        @endif
                    </span>
                </div>
                @if($taxAmount > 0)
                <div class="totals-line">
                    <span class="totals-label text-sm muted">Tax ({{ number_format($taxRate * 100, 2) }}%)</span>
                    <span class="totals-value text-sm">RM {{ number_format($taxAmount, 2) }}</span>
                </div>
                @endif
                <div class="totals-line" style="border-top: 1px solid #d1d5db; margin-top: 6px; padding-top: 12px;">
                    <span class="totals-label bold text-lg">Grand Total</span>
                    <span class="totals-value text-lg bold">RM {{ number_format($grandTotal, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        This invoice was generated electronically and is valid without signature. · Thank you for shopping with {{ $seller['company'] }}!
    </div>
</body>
</html>
