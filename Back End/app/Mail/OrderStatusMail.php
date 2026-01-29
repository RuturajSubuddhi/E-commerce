<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $company;

    public function __construct($order, $company = null)
    {
        $this->order = $order;
        $this->company = $company;
    }

    public function build()
    {
        return $this->subject('Your Order Status Updated')
            ->view('adminPanel.order.order_status')
            ->with([
                'order' => $this->order,
                'company_info_share' => $this->company
            ]);
    }
}