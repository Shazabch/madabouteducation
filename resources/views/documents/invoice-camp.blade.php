<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header img {
            max-height: 80px;
        }

        .company-details {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: x-small;

        }

        thead {
            border-top: 1px solid rgb(177, 175, 175);
            border-bottom: 1px solid rgb(177, 175, 175);
        }

        td {
            padding: 8px;
            text-align: left;
            /* border-bottom: 1px solid #ddd; */
        }

        th {
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }

        .total-details td {
            padding-right: 0;
        }

        .item-column {
            width: 40%;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <td>
            <td><img src="logo.png" alt="Company Logo"></td>
            </td>
            <td>
                <div class="company-details">
                    <h2>Dynamic Learning Strategy Sdn. Bhd
                    </h2>
                    <small>Unit 406, Block A, Level 4</small>
                    <small>Kelana Business Centre</small><br>
                    <small>No 97, Jalan SS7/2, Kelana Jaya</small><br>
                    <small>47301, Petailing Jaya,</small><br>
                    <small>Selangor, Malaysia</small><br>
                    <small>
                        enquiry@madabouteducation.com</small>
                </div>
            </td>
        </tbody>
    </table>
    <div style="margin-top: 20px; border-top:1px solid rgb(177, 175, 175)">
    </div>

    <table>
        <tbody>
            <tr>
                <td>
                    <h1>INVOICE</h1>
                </td>
                <td style="text-align: right"><span style="text-align: left">Grand Total <br><b style="font-size: 27px">MYR {{ number_format($order->net_total ?? '0' ,2) }}</b></span></td>
            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <td><small>
                {{$order->name}} <br>
                P:{{$order->phone}} <br>
                E:{{$order->email}} <br>
                A:{{$order->address}} <br>
                </small></td>
            <td style="text-align: right">
                <small>
                    Order ID: {{$order->full_id}} <br>
                    Date: {{ $order->paid_at ?? $order->created_at}} <br>
                    Payment: Online <br>
                    Transaction ID: {{$order->transaction_id}} <br>
                </small>
            </td>
        </tbody>
    </table>

    <div style="text-align: center; border:1px solid rgb(177, 175, 175); margin-top:20px; margin-bottom:10px">
        <h4>{{$order->payment_status->description}}</h4>
    </div>

    <div style="margin-bottom: 20px">
        <h4 style="text-transform: capitalize; margin-bottom: 5px;">Program/Camp: {{ $order->program_title }}</h4>
        <small>
            Dates: {{$order->bookedProgram->start_date}} - {{$order->bookedProgram->end_date}} <br>
            Venue: {{$order->bookedProgram->venue}}
        </small>
    </div>

    <table>
        <thead>
            <tr>
                <th class="item-column">Child</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->children as $child)
            <tr>
                <td>{{$child->name}}</td>
                <td>MYR {{ number_format($child->sub_total ?? '0', 2) }}</td>
                <td>MYR {{number_format($child->discount ?? '0' , 2)}}</td>
                <td>MYR {{number_format($child->net_total ?? '0' ,2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-top: 50px;">
        <tr>
            <td></td>
            <td style="width: 50%; border:1px solid rgb(177, 175, 175);">
                <table>
                    <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td>MYR {{ number_format($order->sub_total ?? '0', 2) }}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td>MYR {{number_format($order->discount ?? '0' , 2)}}</td>
                        </tr>
                        @if($order->sst)
                        <tr>
                            <td>Sales Tax (SST)</td>
                            <td>MYR {{number_format($order->sst ?? '0' , 2)}}</td>
                        </tr>
                        @endif
                        <tr style="border-top:1px solid rgb(177, 175, 175)">
                            <td><b>Net Total</b></td>
                            <td><b>MYR {{number_format($order->net_total ?? '0' ,2)}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <div style="margin-top: 40px; border-top:1px solid rgb(177, 175, 175)">
        <p>Thank you for your business!</p>
    </div>
</body>

</html>
