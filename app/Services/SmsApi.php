<?php

namespace App\Services;

use App\Account;
use App\Customer;
use App\Message;

class SmsApi
{
    private $service;
    private $adviser;
    private $recipient;
    private $message;
    private $pl;
    private $encoding;
    private $test;

    public function __construct($service, $adviser, $recipient, $message, $pl, $encoding, $test)
    {
        $this->service = $service;
        $this->adviser = $adviser;
        $this->recipient = $recipient;
        $this->message = $message;
        $this->pl = $pl;
        $this->encoding = $encoding;
        $this->test = $test;
    }

    public function send()
    {

        $account = Account::where('service', $this->service)->first();

        $customer = Customer::where('id', $account->customer_id)->first();
        $count_messages = Message::where('account_id', $account->id)->sum('quantity');
        // dd($count_messages);

        if ($customer->count <= $count_messages && $customer->count) {
            return response()->json([

                'status' => '6',
                'msg' => 'Przekroczyłeś limit smsów.',

            ], 400);
        } else {
            static $content;
            $url = 'https://api.smsapi.pl/sms.do';
            $params = array(
                'to' => $this->recipient, //numery odbiorców rozdzielone przecinkami
                'from' => $this->adviser, //pole nadawcy
                'message' => $this->message,
                'test' => $this->test,
                'encoding' => $this->encoding,
                'details' => '1',
                'format' => 'json',
                'normalize' => $this->pl,
            );

            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $params);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . env('API_TOKEN'),
            ));
            $content = curl_exec($c);
            $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);

            curl_close($c);
            return $content;
        }
    }
}
