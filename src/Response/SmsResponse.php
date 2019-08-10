<?php

namespace LinSms\Response;

use LinSms\Traits\ResponseTrait;

class SmsResponse
{
    use ResponseTrait;
    /**
     * @var boolean
     */
    private  $is_sent = false;
    /**
     * @var string
     */
    private  $message = "";
    /**
     * @var string
     */
    private  $recipients = "";
    /**
     * @var string
     */
    private  $sender_id = "";
    /**
     * @var mixed
     */
    private  $refrence_id = "";

    public function __construct($response)
    {
        $this->getStatus($response);
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function getSenderId()
    {
        return $this->sender_id;
    }

    public function getReferenceId()
    {
        return $this->refrence_id;
    }

    public function isSent()
    {
        return $this->is_sent;
    }
}
