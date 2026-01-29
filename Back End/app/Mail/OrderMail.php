<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $details;
    public $company_info_share;

    public function __construct($details, $company_info_share)
    {
        $this->details = $details;
        $this->company_info_share = $company_info_share;
    }

    public function envelope()
    {
        return new Envelope(subject: 'Your Order Has Been Placed');
    }

    // public function content()
    // {
    //     return new Content(view: 'adminPanel.order.order_mail');
    // }

    public function content()
    {
        return new Content(
            view: 'adminPanel.order.order_mail',
            with: [
                'details' => $this->details,
                'company_info_share' => $this->company_info_share
            ]
        );
    }

    // public function build()
    // {
    //     return $this->subject('Your Order Has Been Placed')
    //         ->view('adminPanel.order.order_mail')
    //         ->with([
    //             'details' => $this->details,
    //             'company_info_share' => $this->company_info_share
    //         ]);
    // }


    public function attachments()
    {
        return [];
    }
}
