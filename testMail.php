<?php

namespace voucher\EVoucher;

include_once 'class/vouchergenerate.inc.php';

use E_VOUCHER;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './assets/PHPMailer/src/Exception.php';
require './assets/PHPMailer/src/PHPMailer.php';
require './assets/PHPMailer/src/SMTP.php';

session_start();

if (isset($_POST)) {
    $recipient = $_POST['address'];
    $voucheramount = $_POST['radioRM'];
    $userid = $_POST['userid'];
    $ipaddress = $_POST['ipaddress'];
    $_SESSION['post'] = $_POST;
    #print_r($_SESSION['post']);
} else {
    die("Please try <a href='index.php'>again</a>.");
}

try {
    $objEVoucher = new E_VOUCHER(0, $userid, $voucheramount);
    $result = $objEVoucher->create_voucher();
    #echo "\$result  =$result<br>";
    if ($result != 'Insert Successful!') {
        throw new Exception("Failed to insert.");
    } else {
        $instanceid = $objEVoucher->get_instanceid();
        $expiredate = $objEVoucher->get_expiredate();
        $datecreate = $objEVoucher->get_datecreate();
        $_SESSION['post']['datecreate'] = $datecreate;
        $_SESSION['post']['expiredate'] = $expiredate;

        //create script filename
        #$currURL = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $currURL = "http://" . $ipaddress . $_SERVER['REQUEST_URI'];
        $valCurr = str_replace(basename((__FILE__)),'validateVoucher.php?qrscode='.$instanceid,$currURL);
        echo "<script>console.log('Debug Objects: valCurr = $valCurr');</script>";
        #$encode_ID = urlencode($instanceid);\
        $encode_ID = urlencode($valCurr);
        $_SESSION['post']['encode_ID'] = $encode_ID;
        $qrURL = "qrcodeimage.php?code=$encode_ID";
        $curr = str_replace(basename((__FILE__)), $qrURL, $currURL);
        #echo "curr = " . $curr . "<br>";
        echo "<script>console.log('Debug Objects: qrURL =" . $qrURL . "' );</script>";
        echo "<script>console.log('Debug Objects: basename file =" . basename((__FILE__)) . "' );</script>";
        echo "<script>console.log('Debug Objects: currURL =" . $currURL . "' );</script>";
        echo "<script>console.log('Debug Objects: curr =" . $curr . "' );</script>";

        //Create PNG of Barcode
        $img_dir = './resource/img/qrcode_img.png';
        $output = file_get_contents($curr);
        if(empty($output)){
                throw new Exception('Error Connecting to Server, Cannot resolve assigned Server at <strong> http://'.$ipaddress.'</strong>.');
            }
        file_put_contents($img_dir, $output);

        //create PDF for the E-Voucher
        //include_once 'printToPDF.php';
        //directory of PDF file
        //$evoucher = './resource/pdf/evoucher_tmp.pdf';

        $mail = new PHPMailer(true);
        /**/
        try {
            //Server settings
            #$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            //$mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->Host = 'mail.phh.com.my';                    // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
//            $mail->Username = 'meganet003@gmail.com';                     // SMTP username
            $mail->Username = 'ishin_evoucher_generator@phh.com.my';                     // SMTP username
            //$mail->Password = 'mega6636';                               // SMTP password
            $mail->Password = '@#$ishin1234()!';                               // SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            //Recipients
            //$mail->setFrom('meganet003@gmail.com', '-noreply');
            $mail->setFrom('ishin_evoucher_generaor@phh.com.my', '-noreply');
            #$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $mail->addAddress($recipient);               // Name is optional
            $mail->addReplyTo('ishin_evoucher_generator@phh.com.my', '-noreply');
            $mail->addEmbeddedImage($img_dir, 'qrcode'); //Adds an image to be embedded
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
    }
} catch (Exception $ex) {
    $_SESSION['mailStat'] = 'error';
    $_SESSION['mailMsg'] = $ex->getMessage();
}
echo '<META HTTP-EQUIV="refresh" content="0;URL=form_mailCustomer.php">'; //using META tags instead of headers because headers didn't work in PHP5.3

/**/
