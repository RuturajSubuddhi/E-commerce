<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class OrderReturnedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $return;
    public $company;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $return, $company)
    {
        $this->order   = $order;
        $this->return  = $return;
        $this->company = $company;
    }

    /**
     * Email subject
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Return Request | Order #' . $this->order->invoice_id
        );
    }

    /**
     * Email content
     */
    public function content(): Content
    {
        return new Content(
            view: 'adminPanel.order.Admin.order_returned',
            with: [
                'order'   => $this->order,
                'return'  => $this->return,
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
