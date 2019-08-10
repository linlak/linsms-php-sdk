<?php

namespace LinSms\Traits;

trait ResponseTrait
{
    public $status_code = 0;
    public $status_phrase = "Unknown";
    protected function getStatus($response)
    {
        if ($response) {
            $this->status_code = $response['status_code'];
            $this->status_phrase = $response['status_phrase'];
        }
    }
}
