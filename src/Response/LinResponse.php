<?php

namespace LinSms\Response;

use LinSms\Traits\ResponseTrait;

class LinResponse
{
    use ResponseTrait;

    public function __construct($response)
    {
        $this->getStatus($response);
    }
}
