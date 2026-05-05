<x-mail::message>
<h1 style="text-align: center">New {{ucfirst($type)}} Order</h1>

Hi <b>{{$order->name}}</b>,

Your {{$type}} order has been generated successfully. Please pay to confirm the order. Find Details in the attachment.

# Details

<x-mail::panel>
<b>Order ID:</b> {{$type}}_{{$order->id}}<br>
<b>Name:</b> {{$order->name}}<br>
<b>Email:</b> {{$order->email}}<br>
<b>Phone:</b> {{$order->phone}}<br>
<br>
@if ($order->dicscount>0)
<b>Sub Total:</b> <b>Payment Status</b> {{$order->sub_total}}<br>
<b>Discount:</b> <b>Payment Status</b> {{$order->discount}}<br>
@endif
<b>Total: </b> <b>{{getCurrency()}}</b> {{$order->net_total}}<br>
<b>Payment Status</b> {{$order->payment_status->description}}<br>
@if ($order->payment_status->is(App\Enums\PaymentStatus::Paid))
<b>Paid At</b> {{$order->paid_at}}<br>
<b>Transaction ID</b> {{$order->transaction_id}}<br>
@endif
<br>
@if ($type=="shop")
<h2>Products: {{$order->details()}}</h2>
@elseif ($type=="camp")
<b>Program:</b> {{$order->program_title}} <br>
<b>Total Children:</b> {{$order->children_count}} <br>
@endif
</x-mail::panel>
@if ($order->payment_status->is(App\Enums\PaymentStatus::Paid))
<x-mail::button :url=$pay_now_url>
Pay Now
</x-mail::button>
@endif

Regards,<br>
<b>Mad About Education Group</b> <br>
<small>E: <a href="mailto:enquiry@madabouteducation.com">enquiry@madabouteducation.com</a> <br>
    P: <a href="tel:+601127758056">+6011 2775 8056</a> <br>
    W: <a href="https://madabouteducation.com/">madabouteducation.com</a></small>
</x-mail::message>
