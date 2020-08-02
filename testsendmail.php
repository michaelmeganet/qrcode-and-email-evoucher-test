<?php

$to_email = 'cct3000@gmail.com';
$subject = 'Testing PHP Mail mail() function from webfaction';
$message = 'This mail is sent using the PHP mail function';
$headers = 'From: noreply@company.com';
mail($to_email, $subject, $message, $headers);
?>
