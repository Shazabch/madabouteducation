<?php

namespace App\Http\Controllers;

use App\Api\IPay88;
use App\Api\SenangPay;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Mail\PaymentSuccessfullMail;
use App\Models\Order;
use App\Models\ProgramOrder;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

    public function checkout($type, $id)
    {
        abort_if(!in_array($type, ['camp', 'shop']), 404);
        $order_details = [];
        if ($type == "camp") {
            $order = ProgramOrder::where('id', $id)->firstOrFail();
            // $order_details['detail']="Camp: ".$order->program_title." | Booked For ".$order->children_count." Children";
            $order_details['detail'] = "Camp Booking " . $order->id;
            $order_details['amount'] = $order->net_total;
            $order_details['order_id'] = "camp_" . $order->id;
            $order_details['name'] = $order->name;
            $order_details['email'] = $order->email;
            $order_details['phone'] = $order->phone;
        } elseif ($type == "shop") {
            $order = Order::where('id', $id)->firstOrFail();
            // $order_details['detail']="Shop Order:Items: ".$order->details();
            $order_details['detail'] = "Shop Order " . $order->id;
            $order_details['amount'] = $order->grand_net_total;
            $order_details['order_id'] = "shop_" . $order->id;
            $order_details['name'] = $order->name;
            $order_details['email'] = $order->email;
            $order_details['phone'] = $order->phone;
        }

        if ($order->payment_status->is(PaymentStatus::Paid)) {
            abort('403', 'This order has been paid already.');
        }

        $payment_service = new SenangPay();
        $response = $payment_service->processOrder($order_details);
        $response_body = $response->body();
        // dd($response_body);
        return view('programs.checkout', compact('order', 'response_body'));
    }
    public function paymentProcessed(Request $request)
    {
        $data = (object) null;
        $data->is_successfull = false;
        $data->message = "No Payment Data Found!";
        $data->transaction_id = null;
        $data->order_id = null;
        $data->type = null;

        if (isset($request->status_id, $request->order_id, $request->msg, $request->hash)) {
            $payment_service = new SenangPay();
            # verify that the data was not tempered, verify the hash
            $hashed_string = md5($payment_service->secret_key . urldecode($request->status_id) . urldecode($request->order_id) . urldecode($request->transaction_id) . urldecode($request->msg));

            $order_id_array = explode('_', $request->order_id);
            $data->type = $order_id_array['0'];
            $data->order_id = $order_id_array['1'];

            # if hash is the same then we know the data is valid
            if ($hashed_string == urldecode($request->hash)) {
                # this is a simple result page showing either the payment was successful or failed. In real life you will need to process the order made by the customer
                if (urldecode($request->status_id) == '1') {
                    $data->is_successfull = true;
                    $data->transaction_id = $request->transaction_id;
                    $data->message = urldecode($request->msg) . " .You transaction id is " . $data->transaction_id;
                    $order = null;
                    if ($data->type == 'camp') {
                        $order = ProgramOrder::find($data->order_id);
                        $this->processProgramOrder($data, $data->order_id, false);
                    } elseif ($data->type == 'shop') {
                        $order = Order::find($data->order_id);
                        if ($order && $order->payment_status->is(PaymentStatus::NotPaid)) {
                            $order->payment_status = PaymentStatus::Paid;
                            $order->order_status = OrderStatus::Placed;
                            $order->paid_at = now();
                            $order->transaction_id = $data->transaction_id;
                            $order->save();
                            $order->generateInvoice();

                            // process program orders related to shop order
                            $programOrders = ProgramOrder::where('shop_order_id', $order->id)->get();
                            foreach ($programOrders as $programOrder) {
                                $this->processProgramOrder($data, $programOrder->id, true);
                            }
                            // now send email for shop orders, when program order status is also updated
                            if ((bool)(env('ENABLE_EMAILS', false))) {
                                Mail::to($order->email)
                                    ->cc('enquiry@madabouteducation.com')
                                    ->send(new PaymentSuccessfullMail($order, $data->type));
                            }
                        }
                    }
                    // Mail::to($order->email)->send(new PaymentSuccessfullMail($order,$data->type))
                } else {
                    $data->is_successfull = false;
                    $data->message = urldecode($request->msg);
                }
            } else {
                $data->is_successfull = false;
                $data->message = 'Hashed value is not correct';
            }
        }
        $data->message = str_replace('_', ' ', $data->message);
        return view('payment.processed', compact('data'));
    }



    public function processProgramOrder($data, $order_id, $processingThroughShopOrder = false)
    {
        $order = ProgramOrder::find($order_id);

        if (!$order) {
            Log::warning('ProgramOrder not found', ['order_id' => $order_id]);
            return;
        }

        if ($order->payment_status->is(PaymentStatus::NotPaid)) {
            $order->payment_status = PaymentStatus::Paid;
            $order->paid_at = now();
            $order->transaction_id = $data->transaction_id ?? null;
            $order->save();

            $order->generateInvoice();
            $order->generateChildrenDetails();

            if (!$processingThroughShopOrder && (bool) env('ENABLE_EMAILS', false)) {
                Mail::to($order->email)
                    ->cc('enquiry@madabouteducation.com')
                    ->send(new PaymentSuccessfullMail($order, $data->type ?? 'camp'));
            }

            Log::info('Program order processed successfully', ['order_id' => $order_id]);
        } else {
            Log::info('ProgramOrder already paid', ['order_id' => $order_id]);
        }
    }

    public function checkoutIpay88($type, $id)
    {
        abort_if(!in_array($type, ['camp', 'shop']), 404);
        $order_details = [];
        if ($type == "camp") {
            $order = ProgramOrder::where('id', $id)->firstOrFail();
            // $order_details['detail']="Camp: ".$order->program_title." | Booked For ".$order->children_count." Children";
            $order_details['detail'] = "Camp Booking " . $order->id;
            $order_details['amount'] = $order->net_total;
            $order_details['order_id'] = "camp_" . $order->id;
            $order_details['name'] = $order->name;
            $order_details['email'] = $order->email;
            $order_details['phone'] = $order->phone;
        } elseif ($type == "shop") {
            $order = Order::where('id', $id)->firstOrFail();
            // $order_details['detail']="Shop Order:Items: ".$order->details();
            $order_details['detail'] = "Shop Order " . $order->id;
            $order_details['amount'] = $order->grand_net_total;
            $order_details['order_id'] = "shop_" . $order->id;
            $order_details['name'] = $order->name;
            $order_details['email'] = $order->email;
            $order_details['phone'] = $order->phone;
        }

        if ($order->payment_status->is(PaymentStatus::Paid)) {
            abort('403', 'This order has been paid already.');
        }

        $payment_service = new IPay88();
        $response_body = $payment_service->processOrder($order_details);
        return view('ipay88.form', compact('response_body'));
    }


    public function iPayResponse(Request $request)
    {
        Log::info('iPay88 Response Received', $request->all());

        $refNo    = $request->input("RefNo");
        $transId  = $request->input("TransId");
        $status   = $request->input("Status");
        $errDesc  = $request->input("ErrDesc");

        if (!$refNo || !$transId || $status === null) {
            Log::error('Missing critical response parameters', [
                'RefNo' => $refNo,
                'TransId' => $transId,
                'Status' => $status,
            ]);
            return redirect()->route('home', [
                'status' => 0,
                'message' => 'Invalid payment response.',
            ]);
        }

        $type = null;
        $orderId = null;
        if (strpos($refNo, '_') !== false) {
            [$type, $orderId] = explode('_', $refNo, 2);
        }

        Log::info('Extracted RefNo Data', ['type' => $type, 'orderId' => $orderId]);

        if ((int)$status === 1) {
            switch ($type) {
                case 'camp':
                    $order = ProgramOrder::find($orderId);
                    if ($order) {
                        $this->processProgramOrder((object) [
                            'order_id' => $orderId,
                            'transaction_id' => $transId,
                            'type' => $type,
                        ], $orderId);
                    } else {
                        Log::warning('ProgramOrder not found', ['orderId' => $orderId]);
                    }
                    break;

                case 'shop':
                    $order = Order::find($orderId);
                    if ($order && $order->payment_status->is(PaymentStatus::NotPaid)) {
                        $order->payment_status = PaymentStatus::Paid;
                        $order->order_status = OrderStatus::Placed;
                        $order->paid_at = now();
                        $order->transaction_id = $transId;
                        $order->save();
                        $order->generateInvoice();

                        // Handle linked program orders
                        $programOrders = ProgramOrder::where('shop_order_id', $order->id)->get();
                        foreach ($programOrders as $programOrder) {
                            $this->processProgramOrder((object) [
                                'order_id' => $programOrder->id,
                                'transaction_id' => $transId,
                                'type' => 'camp',
                            ], $programOrder->id, true);
                        }

                        // Send email only after processing program orders
                        if ((bool) env('ENABLE_EMAILS', false)) {
                            Mail::to($order->email)
                                ->cc('enquiry@madabouteducation.com')
                                ->send(new PaymentSuccessfullMail($order, $type));
                        }
                    } else {
                        Log::warning('Shop Order not found or already paid', ['orderId' => $orderId]);
                    }
                    break;

                default:
                    Log::error('Unknown payment type received in RefNo', ['type' => $type]);
                    break;
            }

            $msgStatus = 1;
            $message = 'Thank you for your payment! Transaction ID: ' . $transId;
        } else {
            $msgStatus = 0;
            $message = 'Payment Failed! ' . ($errDesc ?: 'Unknown error');
        }

        session()->flash('status', $status);
        session()->flash('message', $message);

        return redirect()->route('home', [
            'status' => $msgStatus,
            'message' => $message,
        ]);
    }


    // public function iPayResponse(Request $request)
    // {
    //     Log ::info('iPay88 Response', $request->all());

    //     $merchantCode = $request->input("MerchantCode");
    //     $paymentId    = $request->input("PaymentId");
    //     $refNo        = $request->input("RefNo");
    //     $amount       = $request->input("Amount");
    //     $currency     = $request->input("Currency");
    //     $remark       = $request->input("Remark");
    //     $transId      = $request->input("TransId");
    //     $authCode     = $request->input("AuthCode");
    //     $status       = $request->input("Status");
    //     $errDesc      = $request->input("ErrDesc");
    //     $signature    = $request->input("Signature");

    //     // Additional optional fields
    //     $ccName       = $request->input("CCName");
    //     $ccNo         = $request->input("CCNo");
    //     $bankName     = $request->input("S_bankname");
    //     $country      = $request->input("S_country");
    //     $xfield1      = $request->input("Xfield1");
    //     $xfield2      = $request->input("Xfield2");
    //     $xfield3      = $request->input("Xfield3");


    //     $type = null;
    //     $orderId = null;
    //     if (strpos($refNo, '_') !== false) {
    //         [$type, $orderId] = explode('_', $refNo, 2);
    //     }
    //     Log ::info(['type', $type]);
    //     Log ::info(['orderId', $orderId]);
    //     if ($status == 1) {

    //         if ($type == 'shop') {
    //             $order = Order::find($orderId);
    //             if ($order) {
    //                 $order->payment_status = PaymentStatus::Paid;
    //                 $order->order_status = OrderStatus::Placed;
    //                 $order->paid_at = now();
    //                 $order->transaction_id = $transId;
    //                 $order->save();
    //             }
    //         } elseif ($type == 'camp') {
    //             $this->processProgramOrder((object) ['order_id' => $orderId], $orderId, false);
    //         }
    //         $message = 'Thank you for your payment!';
    //     } else {
    //         $message = 'Payment Failed !'.$errDesc;
    //     }

    //     session()->flash('status', $status);
    //     session()->flash('message', $message);

    //     return redirect()->route('home', [
    //         'status' => $status == 1 ? 'success' : 'error',
    //         'message' => $message,
    //     ]);

    // }
}
