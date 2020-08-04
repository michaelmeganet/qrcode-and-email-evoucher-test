<?php

namespace voucher\EVoucherBatch;

include_once 'class/vouchergenerate.inc.php';

use E_VOUCHER;
use SQL;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './assets/PHPMailer/src/Exception.php';
require './assets/PHPMailer/src/PHPMailer.php';
require './assets/PHPMailer/src/SMTP.php';

session_start();

function getCustomerListByCID($cid) {
    $qr = "SELECT * FROM customers WHERE cid = $cid";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    return $result;
}

if (isset($_POST['emailSelected'])) {
    $arr_email = (array) $_POST['emailSelected'];
    #var_dump($arr_email);
    $voucheramount = $_POST['radioRM'];
    $userid = $_POST['userid'];
    $ipaddress = $_POST['ipaddress'];
    $_SESSION['post'] = $_POST;
    #print_r($_SESSION['post']);
} else {
    die("Please try <a href='index.php'>again</a>.");
}

function sendEmail($recipient, //the email recipient
        $img_dir) {  //the directory for image files
    $mail = new PHPMailer(true);
    /**/
    try {
        //Server settings
        #$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
<<<<<<< HEAD
        //$mail->Host = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->Host = 'mail.phh.com.my';                       // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'ishin_evoucher_generator@phh.com.my';                 // SMTP username
        //$mail->Username = 'meganet003@gmail.com';                 // SMTP username
        //$mail->Password = 'mega6636';                             // SMTP password
        $mail->Password = '@#$ishin1234()!';                             // SMTP password
//        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        //Recipients
        //$mail->setFrom('meganet003@gmail.com', '-noreply');
        $mail->setFrom('ishin_evoucher_generator@phh.com.my', '-noreply');
        #$mail->addAddress('joe@example.net', 'Joe User');          // Add a recipient
        $mail->addAddress($recipient);                              // Name is optional
        $mail->addReplyTo('ishin_evoucher_generator@phh.com.my', '-noreply');
//        $mail->addReplyTo('meganet003@gmail.com', '-noreply');
=======
//        $mail->Host = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->Host = 'mail.phh.com.my';
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
//        $mail->Username = 'meganet003@gmail.com';                 // SMTP username
        $mail->Username = 'ishin_evoucher_generator@phh.com.my';
//        $mail->Password = 'mega6636';                             // SMTP password
        $mail->Password = '@#$ishin1234()!';
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        //Recipients
        //$mail->setFrom('meganet003@gmail.com', '-noreply');
        $mail->setFrom('ishin_evoucher_generaor@phh.com.my', '-noreply');
        #$mail->addAddress('joe@example.net', 'Joe User');          // Add a recipient
        $mail->addAddress($recipient);                              // Name is optional
//        $mail->addReplyTo('meganet003@gmail.com', '-noreply');
        $mail->addReplyTo('ishin_evoucher_generator@phh.com.my', '-noreply');
>>>>>>> fecb87d10cb3598718d8700d2c88df9b08e7a3c3
        $mail->addEmbeddedImage($img_dir, 'qrcode');                //Adds an image to be embedded
        #$mail->addCC('cc@example.com');
        #$mail->addBCC('bcc@example.com');
        // Attachments
        #$mail->addAttachment('/var/tmp/file.tar.gz');              // Add attachments
        #$mail->addAttachment('/tmp/image.jpg', 'new.jpg');         // Optional name
        #$mail->addAttachment($evoucher);
        //creating body for message
        ob_start();
        include('testBody.php');
        $body_html = ob_get_contents();
        ob_get_clean();

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
        $mailStat = 'success';
        $mailMsg = "Message has been sent to $recipient";
    } catch (Exception $e) {
        $mailStat = 'error';
        $mailMsg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    $mailResult = array('mailStat' => $mailStat, 'mailMsg' => $mailMsg);

    return $mailResult;
}

//<--Main process-->
$errCount = 0;
$successCount = 0;
$arr_results = array();

foreach ($arr_email as $row) {
    #echo "row = $row<br>";
    $cid = $row;
    $cus_data = getCustomerListByCID($cid);
    $cusName = $cus_data['cus_name'];
    $cusEmail = $cus_data['email'];
    #$rows = explode('|x|', $row);
    #echo"<br>";
    #$cusName = $rows[0];
    $_SESSION['post']['customer_name'] = $cusName;
    #echo "cusname = $cusName<br>";
    #$cusEmail = $rows[1];
    #echo "cusEmail = $cusEmail<br>";
    try {
        $objEVoucher = new E_VOUCHER($cid, $userid, $voucheramount);
        $result = $objEVoucher->create_voucher();
        #echo "\$result = $result<br>";
        if ($result != 'Insert Successful!') {
            throw new Exception("Fail to create Voucher for $cusName. Please Contact Administrator regarding this.");
        } else {
            $instanceid = $objEVoucher->get_instanceid();
            $expiredate = $objEVoucher->get_expiredate();
            $datecreate = $objEVoucher->get_datecreate();
            $_SESSION['post']['datecreate'] = $datecreate;
            $_SESSION['post']['expiredate'] = $expiredate;

            //create script filename
            #$currURL = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            $currURL = "http://" . $ipaddress . $_SERVER['REQUEST_URI'];
            $valCurr = str_replace(basename((__FILE__)), 'validateVoucher.php?qrscode=' . $instanceid, $currURL);
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
            if (empty($output)) {
                throw new Exception('Error Connecting to Server, Cannot resolve assigned Server at <strong> http://' . $ipaddress . '</strong>.');
            }
            file_put_contents($img_dir, $output);

            //create PDF for the E-Voucher
            //include_once 'printToPDF.php';
            //directory of PDF file
            //$evoucher = './resource/pdf/evoucher_tmp.pdf';
            //Begin Preparing to Email
            $mailResult = sendEmail($cusEmail, $img_dir);
            if ($mailResult['mailStat'] == 'error') {
                throw new Exception($mailResult['mailMsg']);
            } else {
                $successCount++;
                $arr_results[] = array('name' => $cusName, 'email' => $cusEmail, 'mailStat' => 'success', 'details' => $mailResult['mailMsg']);
            }
        }
    } catch (Exception $ex) {
        $errCount++;
        $errMsg = $ex->getMessage();
        $arr_results[] = array('name' => $cusName, 'email' => $cusEmail, 'mailStat' => 'fail', 'details' => $errMsg);
    }
}
$_SESSION['mailCount'] = array('successCount' => $successCount, 'errCount' => $errCount);
$_SESSION['mailResults'] = $arr_results;

echo '<META HTTP-EQUIV="refresh" content="0;URL=form_batchMailCustomer.php">'; //using META tags instead of headers because headers didn't work in PHP5.3

/**/
