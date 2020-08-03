<?php

$htmlbody = " Your Mail Contant Here.... You can use html tags here...";

$eol = PHP_EOL;

$to = "cct3000@gmail.com"; //Recipient Email Address

$subject = "Test email with attachment"; //Email Subject

$headers = "From: meganet001@gmail.com" . $eol . "Reply-To: no-reply@gmail.com" . $eol;

$random_hash = md5(date('r', time()));

$headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-" . $random_hash . "\"";

$attachment = chunk_split(base64_encode(file_get_contents('logo.png'))); // Set your file path here
//define the body of the message.

$message = "--PHP-mixed-$random_hash" . $eol . "Content-Type: multipart/alternative; boundary=\"PHP-alt-$random_hash\"" . $eol . $eol;
$message .= "--PHP-alt-$random_hash" . $eol . $eol . "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n" . "Content-Transfer-Encoding: 7bit" . $eol . $eol;

//Insert the html message.
$message .= $htmlbody;
$message .= $eol . $eol . "--PHP-alt-$random_hash--" . $eol . $eol;

//include attachment
$message .= "--PHP-mixed-$random_hash" . $eol . "Content-Type: application/zip; name=\"logo.png\"" . $eol . "Content-Transfer-Encoding: base64" . $eol . "Content-Disposition: attachment" . $eol . $eol;
$message .= $attachment;
$message .= "/r/n--PHP-mixed-$random_hash--";

//send the email
$mail = mail($to, $subject, $message, $headers);

echo $mail ? "Mail sent" : "Mail failed";
?>