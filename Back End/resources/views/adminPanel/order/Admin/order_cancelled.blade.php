<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; }
        .box { max-width: 750px; margin: 30px auto; background: #fff; padding: 20px; }
        .title { text-align: center; font-size: 24px; font-weight: bold; color: #c0392b; }
    </style>
</head>
<body>

<div class="box">

    <div class="title">Order Cancellation Request</div>

    <p><strong>Order No:</strong> #{{ $order->invoice_id }}</p>
    <p><strong>Customer:</strong> {{ $order->customer->name }} ({{ $order->customer->email }})</p>

    <p><strong>Reason:</strong></p>
    <p>{{ $extra['reason'] ?? 'N/A' }}</p>

    @if(!empty($extra['comment']))
        <p><strong>Comment:</strong></p>
        <p>{{ $extra['comment'] }}</p>
    @endif

    <hr>

    <p>Please review and process the cancellation from the admin panel.</p>

    <p style="font-size: 13px; color: gray;">
        {{ $company->company_name ?? 'Your Company' }} — Admin Alert
    </p>

</div>
</body>
</html>
