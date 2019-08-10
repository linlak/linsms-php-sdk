<?php
require_once "./bootstrap.php";
$message = $_POST['message'];
$sender_id = $_POST['sender_id'];
$recipients = $_POST['recipients'];

if ($result = $linClient->sendSMS($sender_id, $message, $recipients)) {
    var_dump($result);
}
