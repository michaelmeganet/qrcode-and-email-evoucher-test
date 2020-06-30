<?php
session_start();
if (isset($_POST)){
    $recipient = $_POST['address'];
    $_SESSION['post'] = $_POST;
    #print_r($_SESSION['post']);
    require  'generaterunno.php';
    $userid1 = 'claudio';
    $getID1 = generate_runno($userid1);

    //get the scriptfilename
    $encode_ID = urlencode($getID1);
    $qrURL = "qrcodeimage.php?code=$encode_ID";
    $currURL = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $curr = str_replace(basename((__FILE__)),$qrURL,$currURL);
    echo "curr = ".$curr."<br>";

    //Create PNG of Barcode
    $output = file_get_contents($curr);
    file_put_contents('./qrcode_img.png', $output);
        
    //create PDF for the E-Voucher
    include_once 'printToPDF.php';
    
    //directory of PDF file
    $evoucher = './pdf/evoucher_tmp.pdf';
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
    $mail->Username   = 'claudio.christyo@gmail.com';                     // SMTP username
    $mail->Password   = 'thraxelonrules50124aaa';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('claudio.christyo@gmail.com', 'Claudio');
    #$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress($recipient);               // Name is optional
    $mail->addReplyTo('claudio.christyo@gmail.com', 'Claudio');
    #$mail->addCC('cc@example.com');
    #$mail->addBCC('bcc@example.com');

    // Attachments
    #$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    #$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->addAttachment($evoucher);
    
    //creating body for message
    ob_start();
    include('testBody.php');
    $body_html = ob_get_contents();
    ob_get_clean();
    ob_end_clean();
    
 
    // Content
    $text_encode = urlencode("You scanned the image!");
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body = $body_html;
    #$mail->Body    = "This is a test Message!<br>"
    #               . "You got a voucher of $vouchertype!<br>"
    #                . "Scan This please !<br>"
    #                ."<img src='qrcodeimage.php?code=$text_encode'/>";
    #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

/**/