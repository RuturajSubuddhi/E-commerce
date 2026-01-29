<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .invoice-box {
            max-width: 750px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #eee;
            background: #fff;
            line-height: 1.6;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th {
            background: #f2f2f2;
            padding: 10px;
            text-align: left;
            font-size: 14px;
            border: 1px solid #ddd;
        }

        table td {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
        }

        .total-row td {
            font-weight: bold;
            border-top: 2px solid #000;
        }

        .info-section {
            margin-top: 20px;
        }

        .info-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            text-align: center;
            color: gray;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <!-- COMPANY NAME -->
        <div class="title">{{ $company_info_share->company_name ?? 'Appticode Pvt. Ltd.' }}</div>

        @php
        $paymentMethods = [0 => 'Cash on Delivery', 1 => 'Credit/Debit Card', 2 => 'UPI'];
        $paymentText = isset($order->payment_type) ? ($paymentMethods[$order->payment_type] ?? 'N/A') : 'N/A';

        $statusText = [
        0 => 'Pending',
        1 => 'Confirmed',
        2 => 'Shipped',
        3 => 'Cancel Requested',
        4 => 'Cancel Accepted',
        5 => 'Cancel Completed',
        6 => 'Completed',
        7 => 'Out for Delivery',
        8 => 'Return Requested',
        9 => 'Return Request Accepted',
        10 => 'Return Request Rejected',
        11 => 'Refund Completed',
        // 4 => 'Cancelled',
        // 5 => 'Returned',
        // 6 => 'Refunded',
        // 7 => 'Delivered'
        ];
        @endphp

        <div class="subtitle">
            Payment Method: <strong>{{ $paymentText }}</strong><br>
            Current Status: <strong>{{ $statusText[$order->order_status] ?? 'N/A' }}</strong>
        </div>

        <hr>

        <!-- ORDER INFO -->
        <h3>Order No: #{{ $order->invoice_id }}</h3>
        <p>Date: {{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</p>

        <!-- PRODUCT TABLE -->
        <table>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
            @foreach ($order->sellDetail as $item)
            <tr>
                <td>{{ $item->product->name ?? 'Product' }}</td>
                <td>{{ $item->sale_quantity }}</td>
                <td class="text-right">{{ number_format($item->unit_sell_price, 2) }}</td>
                <td class="text-right">{{ number_format($item->unit_sell_price * $item->sale_quantity, 2) }}</td>
            </tr>
            @endforeach

            <tr class="total-row">
                <td colspan="3" class="text-right">Cart Subtotal</td>
                <td class="text-right">{{ number_format($order->total_payable_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">VAT</td>
                <td class="text-right">{{ number_format($order->total_vat_amount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Shipping Charges</td>
                <td class="text-right">{{ number_format($order->shipping_cost ?? 0, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="text-right">Order Total</td>
                <td class="text-right">{{ number_format($order->total_payable_amount + ($order->shipping_cost ?? 0) + ($order->total_vat_amount ?? 0), 2) }}</td>
            </tr>
        </table>

        <!-- CUSTOMER DETAILS -->
        <div class="info-section">
            <div class="info-title">Customer Details</div>
            <p>
                Name: {{ $order->user->name ?? 'Customer' }}<br>
                Email: {{ $order->user->email ?? 'N/A' }}<br>
                Phone: {{ $order->user->phone ?? '' }}
            </p>
        </div>

        <!-- DELIVERY ADDRESS -->
        <div class="info-section">
            <div class="info-title">Delivery Address</div>
            <p>
                {{ $order->orderAddress->shipping_address ?? '' }}<br>
                {{ $order->orderAddress->shipping_city ?? '' }}, {{ $order->orderAddress->shipping_state ?? '' }}<br>
                {{ $order->orderAddress->shipping_country ?? '' }} - {{ $order->orderAddress->shipping_zip ?? '' }}
            </p>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>If you have any questions about your order, please contact our support team.</p>
            <p>{{ $company_info_share->company_address ?? 'Infocity, Patia, BBSR- 751021, Odisha' }}</p>
        </div>
    </div>
</body>

</html>