<?php


namespace app\components;


class PayPal
{
    public $mode;

    /**
     * Paypal set express checkout
     * @param $booking Booking
     * @return string
     * */
    public function paypalSetExpressCheckout($order)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($order));
        $response = urldecode(curl_exec($curl));
        parse_str($response, $rest);
        $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $rest['TOKEN'];
        header('Location: ' . $url, true);
        exit();
    }

    public function paypalGetExpressCheckoutDetails($token, $do = false)
    {
        $order = [
            'USER' => 'dmytro.liakin-facilitator_api1.p2h.com',
            'PWD' => '5JCVYGDBDY6KALJZ',
            'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AF1m3r4hkglEQDLgi1p-O-97Eo1h',
            'VERSION' => '124.0',
            'METHOD' => 'GetExpressCheckoutDetails',
            'TOKEN' => $token,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($order));
        $response = urldecode(curl_exec($curl));
        parse_str($response, $rest);
        if ($do) {
            return $this->paypalDoExpressCheckoutPayment($rest);
        }
        return $rest;
    }

    public function paypalDoExpressCheckoutPayment($rest)
    {
        if ($rest['ACK'] == 'Success') {
            $order = [
                'USER' => 'dmytro.liakin-facilitator_api1.p2h.com',
                'PWD' => '5JCVYGDBDY6KALJZ',
                'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AF1m3r4hkglEQDLgi1p-O-97Eo1h',
                'VERSION' => '124.0',
                'METHOD' => 'DoExpressCheckoutPayment',
                'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
                'PAYERID' => $rest['PAYERID'],
                'TOKEN' => $rest['TOKEN'],
                'PAYMENTREQUEST_0_AMT' => $rest['PAYMENTREQUEST_0_AMT'],
            ];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($order));
            $response = urldecode(curl_exec($curl));
            parse_str($response, $rest);
            return $rest;
        }
    }
}