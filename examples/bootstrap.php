<?php
require_once "../vendor/autoload.php";

use LinSms\LinSMSClient;

$client_id = "";
$secret = "";
/**
 * @var LinSms\LinSMSClient
 */
$linClient = LinSMSClient::init($client_id, $secret);
