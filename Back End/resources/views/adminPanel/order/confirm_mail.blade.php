<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { background-color: #f8f8f8; padding: 20px; text-align: center; }
        .content { margin: 20px; }
        .footer { margin: 20px; font-size: 12px; color: #888; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Order Confirmation</h2>
    </div>
 
    <div class="content">
        <p>Dear {{ $order->customer->name ?? 'Customer' }},</p>
        <p>Thank you for your order! Your order <strong>#{{ $order->invoice_id }}</strong> has been confirmed.</p>
 
        <h3>Order Details:</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->sellDetail as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->sale_quantity }}</td>
                    <td>{{ number_format($item->unit_sell_price, 2) }}</td>
                    <td>{{ number_format($item->unit_sell_price * $item->sale_quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
 
        <p><strong>Total Amount: </strong> {{ number_format($order->total_payable_amount, 2) }}</p>
 
        <h3>Shipping Address:</h3>
        <p>
            {{ $order->orderAddress->shipping_address ?? '' }}<br>
            {{ $order->orderAddress->shipping_city ?? '' }},
            {{ $order->orderAddress->shipping_district ?? '' }},
            {{ $order->orderAddress->shipping_division ?? '' }}<br>
            {{ $order->orderAddress->shipping_country ?? '' }} - {{ $order->orderAddress->shipping_zip ?? '' }}<br>
            Phone: {{ $order->orderAddress->shipping_phone ?? '' }}
        </p>
 
        <p>We hope you enjoy your purchase!</p>
    </div>
 
    <div class="footer">
        <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
    </div>
</body>
</html>
 
 