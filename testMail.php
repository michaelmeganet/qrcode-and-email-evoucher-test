<?php

session_start();
include_once 'generateinstanceid.php';

if (isset($_POST)){
    $recipient = $_POST['address'];
    $voucheramount = $_POST['radioRM'];
    $_SESSION['post'] = $_POST;
    #print_r($_SESSION['post']);
    $userid1 = 'claudio';
    $arr_getRunno = generate_runno($userid1,$voucheramount);
    $tID = $arr_getRunno['instancetid'];
    $datecreate = $arr_getRunno['datecreate'];
    $expiredate = $arr_getRunno['expiredate'];
    //get the scriptfilename
    $encode_ID = urlencode($tID);
    $qrURL = "qrcodeimage.php?code=$encode_ID";
    $currURL = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $curr = str_replace(basename((__FILE__)),$qrURL,$currURL);
    echo "curr = ".$curr."<br>";

    //Create PNG of Barcode
    $output = file_get_contents($curr);
    file_put_contents('./qrcode_img.png', $output);
        
    //create PDF for the E-Voucher
    //include_once 'printToPDF.php';
    
    //directory of PDF file
    //$evoucher = './pdf/evoucher_tmp.pdf';
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './assets/PHPMailer/src/Exception.php';
require './assets/PHPMailer/src/PHPMailer.php';
require './assets/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
/**/
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'meganet003@gmail.com';                     // SMTP username
    $mail->Password   = 'mega6636';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('meganet003@gmail.com', '-noreply');
    #$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress($recipient);               // Name is optional
    $mail->addReplyTo('meganet003@gmail.com', '-noreply');
    $mail->addEmbeddedImage('./qrcode_img.png', 'qrcode'); //Adds an image to be embedded
    #$mail->addCC('cc@example.com');
    #$mail->addBCC('bcc@example.com');

    // Attachments
    #$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    #$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    #$mail->addAttachment($evoucher);
    
    //creating body for message
    ob_start();
    include('testBody.php');
    $body_html = ob_get_contents();
    ob_get_clean();
    ob_end_clean();
    
 
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Test Message, QRCode in mail body, without PDF Attachment';
    $mail->Body = $body_html;
    #$mail->Body    = "This is a test Message!<br>"
    #               . "You got a voucher of $vouchertype!<br>"
    #                . "Scan This please !<br>"
    #                ."<img src='qrcodeimage.php?code=$text_encode'/>";
    #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $_SESSION['mailStat'] = 'success';
    $mailMsg = "Message has been sent to $recipient";
} catch (Exception $e) {
    $_SESSION['mailStat'] = 'error';
    $mailMsg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

    $_SESSION['mailMsg'] = $mailMsg;
    #echo '<META HTTP-EQUIV="refresh" content="0;URL=form_mailCustomer.php">'; //using META tags instead of headers because headers didn't work in PHP5.3
         
/**/