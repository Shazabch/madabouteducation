<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;

class IPay88
{
    private $merchant_id;
    public $secret_key;
    private $base_url;
    public bool $is_live;

    public function __construct()
    {
        $this->is_live = (bool) env('IPAY88_LIVE_MODE', false);
        if ($this->is_live) {
            $this->merchant_id = env('IPAY88_LIVE_MERCHANT_ID');
            $this->secret_key = env('IPAY88_LIVE_SECRET_KEY');
            $this->base_url = "https://payment.ipay88.com.my/ePayment/entry.asp";
        } else {
            $this->merchant_id = env('IPAY88_SANDBOX_MERCHANT_ID');
            $this->secret_key = env('IPAY88_SANDBOX_SECRET_KEY');
            $this->base_url = "https://sandbox.ipay88.com.my/ePayment/entry.asp";
        }
    }

    public function processOrder(array $order)
    {
        if (isset($order['detail'], $order['amount'], $order['order_id'], $order['name'], $order['email'], $order['phone'])) {
            $merchantCode = $this->merchant_id;
            $refNo = $order['order_id'];
            $amount = number_format($order['amount'], 2, '.', '') ;
            // $amount ='1.00';
            $amountForHash = str_replace('.', '', $amount);
            $currency = 'MYR';
            $prodDesc = $order['detail'];
            $userName = $order['name'];
            $userEmail = $order['email'];
            $userContact = $order['phone'];

            $hashString = $this->secret_key . $merchantCode . $refNo . $amountForHash . $currency;
            $signature = hash_hmac('sha512', $hashString, $this->secret_key);

            return [
                'action_url' => $this->base_url,
                'merchantCode' => $merchantCode,
                'refNo' => $refNo,
                'amount' => $amount,
                'currency' => $currency,
                'prodDesc' => $prodDesc,
                'userName' => $userName,
                'userEmail' => $userEmail,
                'userContact' => $userContact,
                'signature' => $signature
            ];
        }

        throw new \Exception('Missing required payment fields');
    }
}
