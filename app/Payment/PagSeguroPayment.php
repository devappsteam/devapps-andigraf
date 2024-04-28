<?php
namespace App\Payment;

class PagSeguroPayment
{
    private $credentials;

    public function __construct(PagSeguroCredentials $credentials)
    {
        $this->credentials = $credentials;
    }

    public function getPaymentUrl($xml)
    {
        $url = config('pagseguro.url') . '/checkout/?email=' . $this->credentials->getEmail() . '&token=' . $this->credentials->getToken();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml; charset=UTF-8'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function getStatusPayment($transaction_code){
        $url = config('pagseguro.url') . '/v3/transactions/notifications/'.$transaction_code.'?email=' . $this->credentials->getEmail() . '&token=' . $this->credentials->getToken();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
