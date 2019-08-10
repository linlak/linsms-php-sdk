<?php

namespace LinSms\Contracts;

interface InitContract
{
    public function sendSMS($reference_id, $sender_id, $message, $recipients);
    public function smsStatus($reference_id);
    public function balance();
}
