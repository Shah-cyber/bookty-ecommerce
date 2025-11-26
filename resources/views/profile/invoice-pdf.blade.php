<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        @page { margin: 28mm 18mm; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #111827; font-size: 12px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .muted { color: #6b7280; }
        .h1 { font-size: 22px; font-weight: 700; margin: 0; }
        .h2 { font-size: 16px; font-weight: 700; margin: 0; }
        .section { margin-bottom: 16px; }
        .row { width: 100%; }
        .col-6 { width: 48%; display: inline-block; vertical-align: top; }
        .box { background: #f9fafb; border: 1px solid #e5e7eb; padding: 12px; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f3f4f6; color: #111827; text-transform: uppercase; font-size: 11px; letter-spacing: .02em; }
        th, td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; }
        tfoot td { border: none; }
        .totals td { padding: 6px 10px; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 999px; font-size: 10px; }
        .footer { position: fixed; bottom: -10mm; left: 0; right: 0; text-align: center; font-size: 10px; color: #6b7280; }
        .mb-4 { margin-bottom: 12px; }
        .mb-2 { margin-bottom: 8px; }
        .mt-2 { margin-top: 8px; }
        .bold { font-weight: 700; }
        .table-total { background: #f9fafb; }
        .w-10 { width: 10%; }
        .w-50 { width: 50%; }
        .w-20 { width: 20%; }
    </style>
</head>
<body>
    <div class="section">
        <table>
            <tr>
                <td class="w-50">
                    <div class="h1">Invoice</div>
                    <div class="muted">Invoice No: <span class="bold">{{ $invoiceNumber }}</span></div>
                    <div class="muted">Invoice Date: <span class="bold">{{ $order->created_at->format('d M Y') }}</span></div>
                </td>
                <td class="w-50 text-right">
                    <div class="h2">{{ $seller['company'] }}</div>
                    <div class="muted">{{ $seller['address'] }}</div>
                    <div class="muted">Tax No: {{ $seller['tax_number'] }}</div>
                    <div class="muted">{{ $seller['email'] }} · {{ $seller['phone'] }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section row">
        <div class="col-6">
            <div class="box">
                <div class="bold mb-2">Bill To</div>
                <div>{{ $order->user->name }}</div>
                <div class="muted">{{ $order->user->email }}</div>
                <div class="mt-2">{{ $order->shipping_address }}</div>
                <div>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</div>
                <div class="muted">Phone: {{ $order->shipping_phone }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="box">
                <div class="bold mb-2">Order Details</div>
                <div class="muted">Order Ref: <span class="bold">{{ $order->public_id ?? $order->id }}</span></div>
                <div class="muted">Payment Status: <span class="bold" style="text-transform: capitalize;">{{ $order->payment_status }}</span></div>
                <div class="muted">Order Status: <span class="bold" style="text-transform: capitalize;">{{ $order->status }}</span></div>
            </div>
        </div>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th class="w-10 text-left">#</th>
                    <th class="text-left">Item</th>
                    <th class="w-20 text-right">Qty</th>
                    <th class="w-20 text-right">Unit Price</th>
                    <th class="w-20 text-right">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $idx => $item)
                    <tr>
                        <td class="text-left">{{ $idx + 1 }}</td>
                        <td class="text-left">
                            <div class="bold">{{ $item->book->title }}</div>
                            <div class="muted" style="font-size: 10px;">by {{ $item->book->author }}</div>
                        </td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">RM {{ number_format($item->price, 2) }}</td>
                        <td class="text-right">RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right muted">Subtotal</td>
                    <td class="text-right bold">RM {{ number_format($subTotal, 2) }}</td>
                </tr>
                @if($discount > 0)
                <tr>
                    <td colspan="4" class="text-right muted">Discount</td>
                    <td class="text-right bold">- RM {{ number_format($discount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="4" class="text-right muted">Shipping</td>
                    <td class="text-right bold">
                        @if($shippingCost == 0)
                            Free
                        @else
                            RM {{ number_format($shippingCost, 2) }}
                        @endif
                    </td>
                </tr>
                @if($taxAmount > 0)
                <tr>
                    <td colspan="4" class="text-right muted">Tax ({{ number_format($taxRate * 100, 2) }}%)</td>
                    <td class="text-right bold">RM {{ number_format($taxAmount, 2) }}</td>
                </tr>
                @endif
                <tr class="table-total">
                    <td colspan="4" class="text-right bold">Grand Total</td>
                    <td class="text-right bold">RM {{ number_format($grandTotal, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        This invoice was generated electronically and is valid without signature · {{ $seller['company'] }}
    </div>
</body>
</html>
