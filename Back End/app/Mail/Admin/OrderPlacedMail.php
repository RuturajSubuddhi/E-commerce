<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable; // ✅ MUST BE THIS
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class OrderPlacedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $company;

    public function __construct($order, $company)
    {
        $this->order   = $order;
        $this->company = $company;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Order Received | #' . $this->order->invoice_id
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'adminPanel.order.Admin.order_placed',
            with: [
                'order'   => $this->order,
                'company' => $this->company,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
