<?php

namespace LinSms\Response;

use LinSms\Traits\ResponseTrait;
use LinSms\Util\HttpCodes;

class BalanceResponse
{
    use ResponseTrait;
    /**
     * @var int
     */
    private $balance = 0;

    public function __construct($response)
    {
        $this->getStatus($response);

        if ($this->status_code === HttpCodes::HTTP_OK) {
            $data = $response['data'];
            $this->balance = $data['balance'];
        }
    }

    public function getBalance()
    {
        return $this->balance;
    }
}
