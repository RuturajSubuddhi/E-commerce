<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReturnRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $company;
    public $reason;
    public $comment;
    public $imageUrl;

    public function __construct($order, $company, $return)
    {
        $this->order = $order;
        $this->company = $company;

        // values sent from controller
        $this->reason = $return->reason;
        $this->comment = $return->comment;

        // full URL for image
        $this->imageUrl = $return->image
            ? asset('uploads/returns/' . $return->image)
            : null;
    }

    public function build()
    {
        return $this->subject('Return Request Submitted')
            ->view('adminPanel.order.return_request')
            ->with([
                'order' => $this->order,
                'reason' => $this->reason,
                'comment' => $this->comment,
                'imageUrl' => $this->imageUrl,
                'company' => $this->company,
            ]);
    }
}
