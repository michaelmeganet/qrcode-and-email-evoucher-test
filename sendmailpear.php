<?php

require_once "Mail.php";

$from_addr = "Me <meganet001@gmail.com>";
$to = "user <cct3000@gmail.com>";
$subject = "Hello!";
$body = "Dear Team, here is my message text.";

$headers = array("From" => $from_addr,
    "To" => $to,
    "Subject" => $subject);
$smtp = Mail::factory("smtp", array('host' => "smtp.webfaction.com",
            'auth' => true,
            'username' => "meganetinfo",
            'password' => "@#mega6636"));

$mail = $smtp->send($to, $headers, $body);

if ($mail) {
    echo "Message successfully sent!";
} else {
    echo "Message delivery failed...";
}
?>