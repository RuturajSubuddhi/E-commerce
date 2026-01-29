<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Cancellation Request</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">

    <table width="100%" cellspacing="0" cellpadding="0" 
           style="max-width:600px; margin:0 auto; background:#ffffff; padding:20px; border-radius:8px;">
        
        <!-- Header -->
        <tr>
            <td style="text-align:center; padding-bottom:20px;">
                <h2 style="color:#333; margin:0;">Order Cancellation Request</h2>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="font-size:15px; color:#444; line-height:1.6;">

                <p>Hello {{ $order->customer->name ?? ($order->customer->email ?? 'Customer') }},</p>

                <p>We have received your cancellation request for the following order:</p>

                <!-- Order Info Table -->
                <table width="100%" cellpadding="8" cellspacing="0" 
                       style="background:#fafafa; border:1px solid #eee; margin:15px 0; font-size:14px; border-radius:6px;">

                    <tr>
                        <td style="width:35%;"><strong>Order ID:</strong></td>
                        <td>#{{ $order->invoice_id }}</td>
                    </tr>

                    <tr>
                        <td><strong>Reason:</strong></td>
                        <td>{{ $reason }}</td>
                    </tr>

                    @if(!empty($comment))
                    <tr>
                        <td><strong>Comment:</strong></td>
                        <td>{{ $comment }}</td>
                    </tr>
                    @endif

                    <tr>
                        <td><strong>Status:</strong></td>
                        <td style="color:#d9534f; font-weight:bold;">Pending Review</td>
                    </tr>

                </table>

                <p>Our team will review your request and update your order status soon.</p>

                <p>If you have any questions, simply reply to this email or contact our support team.</p>

                <br>

                <p>
                    Warm regards,<br>
                    <strong>{{ $company->company_name ?? 'Our Store' }}</strong>
                </p>

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="text-align:center; padding-top:15px; font-size:12px; color:#999;">
                © {{ date('Y') }} {{ $company->company_name ?? 'Our Store' }}. All Rights Reserved.
            </td>
        </tr>

    </table>

</body>
</html>
