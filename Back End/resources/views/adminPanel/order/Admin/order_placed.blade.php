<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Order Received</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; }
        .box { max-width: 750px; margin: 30px auto; background: #fff; padding: 20px; }
        .title { text-align: center; font-size: 24px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; font-size: 14px; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
        .footer { margin-top: 30px; font-size: 13px; color: gray; text-align: center; }
    </style>
</head>
<body>

<div class="box">

    <div class="title">
        New Order Received
    </div>

    <p><strong>Order No:</strong> #{{ $order->invoice_id }}</p>
    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</p>

    <h3>Customer Details</h3>
    <p>
        Name: {{ $order->user->name }} <br>
        Email: {{ $order->user->email }} <br>
        Phone: {{ $order->orderAddress->shipping_phone ?? '' }}
    </p>

    <h3>Ordered Products</h3>
    <table>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th class="right">Price</th>
            <th class="right">Total</th>
        </tr>

        @foreach($order->sellDetail as $item)
        <tr>
            <td>{{ $item->product->name ?? 'Product' }}</td>
            <td>{{ $item->sale_quantity }}</td>
            <td class="right">{{ number_format($item->unit_sell_price, 2) }}</td>
            <td class="right">{{ number_format($item->unit_sell_price * $item->sale_quantity, 2) }}</td>
        </tr>
        @endforeach

        <tr>
            <td colspan="3" class="right"><strong>Order Total</strong></td>
            <td class="right"><strong>{{ number_format($order->total_payable_amount, 2) }}</strong></td>
        </tr>
    </table>

    <div class="footer">
        {{ $company->company_name ?? 'Your Company' }} — Admin Notification
    </div>

</div>
</body>
</html>
