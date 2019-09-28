<?php

namespace LinSms\Util;

class Constants
{
    const API_URI = "https://lin-sms.com/webapi";
    const SEND_URI = self::API_URI . "/send";
    const STATUS_URI = self::API_URI . "/sms-status/";
    const BALANCE_URI = self::API_URI . "/balance";
    //payments
    const PAY_URI=self.API_URI."/payments";
    const PAY_BAL=self.PAY_URI."/balance";
    //deposit
    const DEPOSIT_URI=self.PAY_URI."/deposit";
    const DEPOSIT_STATUS=self.DEPOSIT_URI."/status/";
    //payout    
    const PAYOUT_URI=self.PAY_URI."/payout";
    const PAYOUT_STATUS=self.PAYOUT_URI."/status/";
    //headers
    const H_AUTH = "Authorization";
    const H_C_TYPE = "Content-Type";
}
