<?php

namespace AmirAghaee\rahyabsms;

use SoapClient;

class RahyabService
{
    protected $username;
    protected $password;
    private $shortcode;
    private $baseUrl;
    private $option;

    public function __construct()
    {
        if (!extension_loaded('curl')) {
            die('Curl extension not loaded');
        }

        if (!extension_loaded('soap')) {
            die('Soap extension not loaded');
        }

        $this->username = env('RAHYAB_SMS_USERNAME');
        $this->password = env('RAHYAB_SMS_PASSWORD');
        $this->shortcode = env('RAHYAB_SMS_SHORTCODE');

        if (is_null($this->username) || is_null($this->password)) {
            die('env value has not been sent');
        }

        $this->option = array(
            'cache_wsdl' => 0,
            'trace' => 1,
            'stream_context' => stream_context_create(array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            )));
        $this->baseUrl = 'http://www.linepayamak.ir/Post/Send.asmx?wsdl';
    }

    public function send($number, $message, $recId = null)
    {
        try {
            $client = new SoapClient($this->baseUrl, $this->option);
            $parameters = [
                'username' => $this->username,
                'password' => $this->password,
                'from' => $this->shortcode,
                'to' => [$number],
                'text' => $message,
                'isflash' => false,
                'udh' => "",
                'recId' => $recId == null ? array(0) : array((string)$recId),
                'status' => array(0),
            ];

            return ($client->SendSms($parameters))->SendSmsResult;
        } catch (\SoapFault $e) {
            echo $e->getMessage();
        }
    }

    public function getCredit()
    {
        try {
            $client = new SoapClient($this->baseUrl, $this->option);
            $parameters = [
                'username' => (string)$this->username,
                'password' => (string)$this->password,
            ];
            return ($client->getCredit($parameters))->GetCreditResult;
        } catch (\SoapFault $e) {
            echo $e->getMessage();
        }
    }

    public function GetExpireDate()
    {
        try {
            $client = new SoapClient($this->baseUrl, $this->option);
            $parameters = [
                'username' => (string)$this->username,
                'password' => (string)$this->password,
            ];
            return ($client->GetExpireDate($parameters))->GetExpireDateResult;
        } catch (\SoapFault $e) {
            echo $e->getMessage();
        }
    }
}
