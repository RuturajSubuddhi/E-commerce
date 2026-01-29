<?php
 
namespace App\Mail;
 
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
 
class ConfirmOrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
 
    public $order;
 
    /**
     * Pass order details into the email
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
 
    /**
     * Email Subject
     */
    public function envelope()
    {
        // If order has at least 1 product
        $productName = $this->order->sellDetail[0]->product->name ?? 'Your Order';
 
        return new Envelope(
            subject: 'Order Successful: ' . $productName,
        );
    }
 
    /**
     * Email Body
     */
    public function content()
    {
        return new Content(
            view: 'adminPanel.order.confirm_mail',
            with: [
                'order' => $this->order
            ]
        );
    }
 
    /**
     * No attachments
     */
    public function attachments()
    {
        return [];
    }
}
 
 