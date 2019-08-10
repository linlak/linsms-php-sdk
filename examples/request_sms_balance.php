<?php

require_once "./bootstrap.php";

use LinSms\Util\HttpCodes;

$result = $linClient->balance();
if ($result) {
    if ($result->status_code === HttpCodes::HTTP_OK) {
        echo $result->getBalance();
    }
}
