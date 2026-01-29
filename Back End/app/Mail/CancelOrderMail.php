<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancelOrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $reason;
    public $comment;
    public $company;

    public function __construct($order, $reason, $comment = null, $company = null)
    {
        $this->order   = $order;
        $this->reason  = $reason;
        $this->comment = $comment;
        $this->company = $company;
    }

    /**
     * Set email subject
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Order Cancellation Request Received'
        );
    }

    /**
     * Set email view + data
     */
    public function content()
    {
        return new Content(
            view: 'adminPanel.order.order-cancel',  // your blade file
            with: [
                'order'   => $this->order,
                'reason'  => $this->reason,
                'comment' => $this->comment,
                'company' => $this->company,
            ]
        );
    }

    /**
     * Attachments (if any)
     */
    public function attachments()
    {
        return [];
    }
}
