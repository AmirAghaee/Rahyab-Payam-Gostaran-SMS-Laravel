<?php

namespace AmirAghaee\rahyabsms;


use AmirAghaee\rahyabsms\Exceptions\RahyabSmsException;
use AmirAghaee\rahyabsms\Log\SmsLogging;
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
            throw new RahyabSmsException("Curl extension not loaded");
        }

        if (!extension_loaded('soap')) {
            throw new RahyabSmsException("Soap extension not loaded");
        }

        $this->baseUrl = 'http://www.linepayamak.ir/Post/Send.asmx?wsdl';
        $this->username = env('RAHYAB_SMS_USERNAME');
        $this->password = env('RAHYAB_SMS_PASSWORD');
        $this->shortcode = env('RAHYAB_SMS_SHORTCODE');

        if (is_null($this->username) || is_null($this->password)) {
            throw new RahyabSmsException("env values has not been sent");
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
    }

    /**
     * Simple send message with smsonline.ir account and line number
     *
     * @param $number
     * @param $message
     * @param null $recId
     *
     * @return string, return status
     */
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
            $status = ($client->SendSms($parameters))->SendSmsResult;

            SmsLogging::loggingInDB($number, $message, $status, $recId);

            return $status;
        } catch (\SoapFault $e) {
            echo $e->getMessage();
        }
    }

    /**
     * send message with smsonline.ir account and line number to several number
     *
     * @param array $numbers
     * @param $message
     * @param null $recId
     *
     * @return string, return status
     */
    public function sendAll($numbers, $message, $recId = null)
    {
        try {
            $client = new SoapClient($this->baseUrl, $this->option);
            $parameters = [
                'username' => $this->username,
                'password' => $this->password,
                'from' => $this->shortcode,
                'to' => $numbers,
                'text' => $message,
                'isflash' => false,
                'udh' => "",
                'recId' => $recId == null ? array(0) : array((string)$recId),
                'status' => array(0),
            ];
            $status = ($client->SendSms($parameters))->SendSmsResult;
            foreach ($numbers as $number) {
                SmsLogging::loggingInDB($number, $message, $status, $recId);
            }

            return $status;
        } catch (\SoapFault $e) {
            echo $e->getMessage();
        }
    }


    /**
     * this method return your credit in http://smsonline.ir/
     *
     * @return string
     */
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

    /**
     * this method return your expire data account in http://smsonline.ir/
     *
     * @return string
     */
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
