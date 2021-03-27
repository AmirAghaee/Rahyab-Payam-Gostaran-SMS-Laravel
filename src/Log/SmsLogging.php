<?php

namespace AmirAghaee\rahyabsms\Log;

use AmirAghaee\rahyabsms\Models\SmsLog;

class SmsLogging
{
    protected $loggingIsEnable;

    public function __construct()
    {
        $this->loggingIsEnable = env('RAHYAB_SMS_ENABLE_LOGS');
    }

    /**
     * This method used for log the messages to the database if "RAHYAB_SMS_ENABLE_LOGS" set to true.
     *
     * @param string $number
     * @param string $message
     * @param string $status
     * @param string $recId (optional)
     */
    public static function loggingInDB($number, $message, $status, $recId = null)
    {
        if (!env('RAHYAB_SMS_ENABLE_LOGS')) return;

        SmsLog::create([
            'shortcode' => env('RAHYAB_SMS_SHORTCODE'),
            'to' => $number,
            'message' => $message,
            'recId' => $recId,
            'status' => $status,
        ]);
    }
}
