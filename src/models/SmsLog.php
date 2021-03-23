<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $shortcode
 * @property string $to
 * @property string $message
 * @property string $recId
 * @property string $status
 * Class SmsLog
 */
class SmsLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shortcode',
        'to',
        'message',
        'recId',
        'status',
    ];


}
