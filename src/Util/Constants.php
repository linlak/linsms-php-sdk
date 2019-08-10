<?php

namespace LinSms\Util;

class Constants
{
    const API_URI = "https://lin-sms.com/webapi";
    const SEND_URI = static::API_URI . "/send";
    const STATUS_URI = static::API_URI . "/sms-status/";
    const BALANCE_URI = static::API_URI . "/balance";
    const H_AUTH = "Authorization";
    const H_C_TYPE = "Content-Type";
}
