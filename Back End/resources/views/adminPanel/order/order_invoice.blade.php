<!DOCTYPE html>
<html>
 
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
 
    <style>
        @page {
            margin: 20px;
        }
 
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #ffffff;
        }
 
        .invoice-meta-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: separate;
            border-spacing: 10px;
        }
 
        .invoice-meta-table td {
            width: 50%;
            vertical-align: top;
        }
 
 
        /* WATERMARK */
        .watermark {
            position: fixed;
            top: 35%;
            left: 20%;
            width: 60%;
            opacity: 0.06;
            z-index: -1;
        }
 
        /* HEADER */
        .header {
            background: #FF6F00;
            color: #ffffff;
            padding: 15px;
            border-radius: 8px;
        }
 
        .company-name {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ffffff;
            font-weight: 700;
        }
 
        .company-info {
            font-size: 11px;
            margin-top: 4px;
            color: #ffffff;
            font-weight: 700;
        }
 
        /* INVOICE INFO */
        .invoice-meta {
            margin-top: 15px;
            display: flex !important;
            justify-content: space-between !important;
        }
 
        .meta-box {
            width: 48%;
            background: #f8f8f8;
            padding: 10px;
            border-radius: 6px;
        }
 
        .meta-box table td {
            font-size: 11px;
            vertical-align: top;
        }
 
        .meta-box strong {
            display: block;
            margin-bottom: 4px;
        }
 
        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
 
        th {
            background: #FF6F00;
            color: #ffffff;
            padding: 10px;
            font-size: 12px;
            font-weight: 600;
        }
 
        td {
            padding: 9px;
            border-bottom: 1px solid #ddd;
        }
 
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
 
        .right {
            text-align: left;
        }
 
        /* TOTALS */
        .totals {
            margin-top: 20px;
            width: 40%;
            float: right;
            background: #f8f8f8;
            padding: 12px;
            border-radius: 8px;
        }
 
        .totals p {
            margin: 6px 0;
        }
 
        .totals .grand {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }
 
        /* FOOTER */
        .footer {
            position: fixed;
            bottom: 15px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #777;
            justify-content: center;
        }
    </style>
</head>
 
<body>
 
    <!-- WATERMARK LOGO -->
    <img src="{{ public_path($company->company_logo)  }}" class="watermark">
 
    <!-- HEADER -->
    <div class="header">
        <div class="company-name">{{ $company->name ?? 'ANIMEZZ' }}</div>
        <div class="company-info">
            Address: {{ $company->company_address ?? '' }} <br>
            Email: {{ $company->email ?? '' }}
        </div>
    </div>
 
    <table class="invoice-meta-table" width="100%" cellspacing="0" cellpadding="0">
        @php
        $paymentMethods = [
        0 => 'Cash on Delivery',
        1 => 'Credit/Debit Card',
        2 => 'UPI'
        ];
        $paymentText = $paymentMethods[$order->payment_type] ?? 'N/A';
        @endphp
 
        <tr>
            <!-- LEFT META -->
            <td class="meta-box" width="50%" valign="top">
                <table width="100%" cellpadding="2">
                    <tr>
                        <td width="40%"><strong>Invoice No:</strong></td>
                        <td width="60%">{{ $order->invoice_id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Order Date:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment:</strong></td>
                        <td>{{ $paymentText }}</td>
                    </tr>
                </table>
            </td>
 
            <!-- RIGHT META -->
            <td class="meta-box" width="50%" valign="top">
                <table width="100%" cellpadding="2">
                    <tr>
                        <td width="35%"><strong>Customer:</strong></td>
                        <td width="65%">{{ $order->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td>{{ $order->orderAddress->shipping_phone ?? '' }}</td>
                    </tr>
                    <tr>
                        <td valign="top"><strong>Address:</strong></td>
                        <td>
                            {{ $order->orderAddress->shipping_address ?? '' }},
                            {{ $order->orderAddress->shipping_city ?? '' }},
                            {{ $order->orderAddress->shipping_state ?? '' }},
                            {{ $order->orderAddress->shipping_country ?? '' }} -
                            {{ $order->orderAddress->shipping_zip ?? '' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
 
 
 
    <!-- META -->
 
 
    <!-- ITEMS -->
    <table>
        <thead>
            <tr>
                <th class="right">Serial No</th>
                <th class="right">Product Name</th>
                <th class="right">Price</th>
                <th class="right">Qty</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->sellDetail as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product->name ?? '' }}</td>
                <td class="right">₹{{ number_format($item->unit_sell_price, 2) }}</td>
                <td class="right">{{ $item->sale_quantity }}</td>
                <td class="right">
                    ₹{{ number_format($item->unit_sell_price * $item->sale_quantity, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
 
    <!-- TOTALS -->
    <div class="totals">
        <p><strong>Subtotal:</strong> ₹{{ number_format($order->sub_total, 2) }}</p>
        <p><strong>Shipping:</strong> ₹{{ number_format($order->shipping_cost, 2) }}</p>
        @if($order->promo_discount > 0)
        <p><strong>Discount:</strong> -₹{{ number_format($order->promo_discount, 2) }}</p>
        @endif
        <p class="grand">Total Payable: ₹{{ number_format($order->total_payable_amount, 2) }}</p>
    </div>
 
    <!-- FOOTER -->
    <div class="footer">
        <table width="100%">
            <tr>
                <td align="center">
                     <strong style="font-size: 20px; font-weight:500;">Thank you for shopping with</strong> -
                    <strong style="font-size: 20px; font-weight:500;">{{ $company->name ?? 'ANIMEZZ' }}</strong>
                    |
                     <strong style="font-size: 20px; font-weight:500;">{{ $company->website_url ?? $company->website ?? 'https://animezz.in/' }}</strong>
                </td>
            </tr>
        </table>
    </div>
 
 
</body>
 
</html>
 