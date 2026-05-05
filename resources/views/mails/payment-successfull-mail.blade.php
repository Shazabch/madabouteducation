<x-mail::message>
<h1 style="text-align: center">Payment Successful</h1>

Hi <b>{{$order->name}}</b>,

You have successfully paid for the order <b>{{$order->full_id}}</b>. Find Details in the attachment.

# Order Details

<x-mail::panel>
<b>Order ID:</b> {{$order->full_id}}<br>
<b>Name:</b> {{$order->name}}<br>
<b>Email:</b> {{$order->email}}<br>
<b>Phone:</b> {{$order->phone}}<br>
</x-mail::panel>

<b>Payment Details</b>
<x-mail::panel>
@if ($order->grand_discount>0)
<b>Sub Total:</b> <b>{{getCurrency()}}</b> {{$order->grand_sub_total}}<br>
<b>Discount:</b> <b>{{getCurrency()}}</b> {{$order->grand_discount}}<br>
@endif
<b>Total: </b> <b>{{getCurrency()}}</b> {{$order->grand_net_total}}<br>

<b>Payment Status: </b> {{$order->payment_status->description}}<br>
@if ($order->payment_status->is(App\Enums\PaymentStatus::Paid))
<b>Paid At: </b> {{$order->paid_at}}<br>
<b>Transaction ID: </b> {{$order->transaction_id}}<br>
@endif
</x-mail::panel>

<x-mail::panel>
@if ($type=="shop")
<h2>Products: {{$order->details()}}</h2>
@elseif ($type=="camp")
<b>Program:</b> {{$order->program_title}} <br>
<b>Total Children:</b> {{$order->children_count}} <br>
@endif
</x-mail::panel>


@if(count($relatedProgramOrders))
<b>Program Details</b> <br>
<x-mail::panel>
@foreach ($relatedProgramOrders as $pOrder)
<b>Program:</b> {{$pOrder->program_title}} <br>
<b>Total Children:</b> {{$pOrder->children_count}} <br>

@endforeach
</x-mail::panel>
@endif

<b style="color: red">You Can find invoice and documents in the attachments.</b>


Regards,<br>
<b>Mad About Education Group</b> <br>
<small>E: <a href="mailto:enquiry@madabouteducation.com">enquiry@madabouteducation.com</a> <br>
    P: <a href="tel:+601127758056">+6011 2775 8056</a> <br>
    W: <a href="https://madabouteducation.com/">madabouteducation.com</a></small>
</x-mail::message>
