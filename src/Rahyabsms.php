<?php


namespace AmirAghaee\rahyabsms;


use Illuminate\Support\Facades\Facade;

/**
 * Class Rahyabsms
 *
 * @method static string send(string $mobile, string $message, string $recId = null)
 * @method static string sendAll(array $mobiles, string $message, string $recId = null)
 * @method static string getCredit()
 * @method static string GetExpireDate()
 *
 */
class Rahyabsms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Rahyabsms';
    }
}
