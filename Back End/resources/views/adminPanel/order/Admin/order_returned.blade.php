<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Return Request</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; }
        .box { max-width: 750px; margin: 30px auto; background: #fff; padding: 20px; }
        .title { text-align: center; font-size: 24px; font-weight: bold; color: #2980b9; }
    </style>
</head>
<body>

<div class="box">

    <div class="title">Return Request Received</div>

    <p><strong>Order No:</strong> #{{ $order->invoice_id }}</p>
    <p><strong>Customer:</strong> {{ $order->customer->name }} ({{ $order->customer->email }})</p>

    <p><strong>Return Reason:</strong></p>
    <p>{{ $extra->reason ?? 'N/A' }}</p>

    @if(!empty($extra->comment))
        <p><strong>Comment:</strong></p>
        <p>{{ $extra->comment }}</p>
    @endif

    @if(!empty($extra->image))
        <p>
            <strong>Attached Image:</strong><br>
            <a href="{{ asset('uploads/returns/'.$extra->image) }}" target="_blank">
                View Image
            </a>
        </p>
    @endif

    <hr>

    <p>Please review and take action from the admin dashboard.</p>

    <p style="font-size: 13px; color: gray;">
        {{ $company->company_name ?? 'Your Company' }} — Admin Notification
    </p>

</div>
</body>
</html>
