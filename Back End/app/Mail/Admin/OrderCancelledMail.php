<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class OrderCancelledMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $reason;
    public $comment;
    public $company;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $reason, $comment, $company)
    {
        $this->order   = $order;
        $this->reason  = $reason;
        $this->comment = $comment;
        $this->company = $company;
    }

    /**
     * Email subject
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Cancellation Request | Order #' . $this->order->invoice_id
        );
    }

    /**
     * Email content
     */
    public function content(): Content
    {
        return new Content(
            view: 'adminPanel.order.Admin.order_cancelled',
            with: [
                'order'   => $this->order,
                'reason'  => $this->reason,
                'comment' => $this->comment,
                'company' => $this->company,
            ]
        );
    }

    /**
     * Attachments (none)
     */
    public function attachments(): array
    {
        return [];
    }
}
