<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public  $pay_now_url;
    public  $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order=$order;
        $this->type=explode('_',$order->full_id)['0'];
        $this->pay_now_url=route('payment.checkout',[$this->type,$this->order->id]);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'New '.ucfirst($this->type).' Order|MAE',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mails.new-order',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $attatchments=[];
        if($this->order->invoice!=null && file_exists($this->order->invoice)){
            $attatchments[]=Attachment::fromPath($this->order->invoice)->as('invoice.pdf');
        }
        if(isset($this->order->children_details) && $this->order->children_details !=null && file_exists($this->order->children_details)){
            $attatchments[]=Attachment::fromPath($this->order->children_details)->as('children_details.pdf');
        }
        return $attatchments;
    }
}
