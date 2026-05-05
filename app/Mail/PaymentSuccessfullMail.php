<?php

namespace App\Mail;

use App\Models\ProgramOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessfullMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $type;
    public $relatedProgramOrders=[];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order,$type)
    {
        $this->order=$order;
        $this->type=$type;
        if($this->type == "shop"){
            $this->relatedProgramOrders=ProgramOrder::with('bookedProgram')->where('shop_order_id',$this->order->id)->get();
        }
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'MAE|Payment Successful',
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
            markdown: 'mails.payment-successfull-mail',
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
            $attatchments[]=Attachment::fromPath($this->order->invoice);
        }
        if(isset($this->order->children_details) && $this->order->children_details !=null && file_exists($this->order->children_details)){
            $attatchments[]=Attachment::fromPath($this->order->children_details)->as('children_details.pdf');
        }
        if(count($this->relatedProgramOrders)){
            foreach($this->relatedProgramOrders as $pOrder){
                if(isset($pOrder->children_details) && $pOrder->children_details !=null && file_exists($pOrder->children_details)){
                    $attatchments[]=Attachment::fromPath($pOrder->children_details)->as('children_details'.preg_replace('/[^\w]+/', '_', $pOrder->program_title).$pOrder->id.'.pdf');
                }
            }
        }
        return $attatchments;
    }
}
