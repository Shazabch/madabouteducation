<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;

class SenangPay{
    private $merchant_id;
    public $secret_key;
    private $base_url;
    public bool $is_live;

    public function __construct()
    {
        $this->is_live=(bool) env('SNPAY_LIVE_MODE',false);
        if($this->is_live){
            $this->merchant_id=env('SNPAY_LIVE_MERCHANT_ID');
            $this->secret_key=env('SNPAY_LIVE_SECRET_KEY');
            $this->base_url="https://app.senangpay.my/payment/".$this->merchant_id;
        }else{
            $this->merchant_id=env('SNPAY_SANDBOX_MERCHANT_ID');
            $this->secret_key=env('SNPAY_SANDBOX_SECRET_KEY');
            $this->base_url="https://sandbox.senangpay.my/payment/".$this->merchant_id;
        }
    }

    public function processOrder(array $order)
    {
        # this part is to process data from the form that user key in, make sure that all of the info is passed so that we can process the payment
        if(isset($order['detail'],$order['amount'],$order['order_id'],$order['name'],$order['email'],$order['phone'])){
             # assuming all of the data passed is correct and no validation required. Preferably you will need to validate the data passed
            $hashed_string = md5($this->secret_key.urldecode($order['detail']).urldecode($order['amount']).urldecode($order['order_id']));
            $order['hash']=$hashed_string;

            $response=Http::asForm()->post($this->base_url,$order);
            return $response;

        }
    }
}
