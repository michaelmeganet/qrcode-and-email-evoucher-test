<?php

namespace voucher\EVoucher;

include_once 'class/vouchergenerate.inc.php';

use E_VOUCHER;

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;
//require './assets/PHPMailer/src/Exception.php';
//require './assets/PHPMailer/src/PHPMailer.php';
//require './assets/PHPMailer/src/SMTP.php';

session_start();

if (isset($_POST)) {
    $recipient = $_POST['address'];
    $voucheramount = $_POST['radioRM'];
    $userid = $_POST['userid'];
    $ipaddress = $_POST['ipaddress'];
    $_SESSION['post'] = $_POST;
    print_r($_SESSION['post']);
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
        echo "<br> List down \$_SESSION variables <br>";
        print_r($_SESSION);
        echo "<br>";
        echo "\$instanceid = $instanceid <br>";
        echo "\$expiredate = $expiredate <br>";
        echo "\$datecreate = $datecreate <br>";
        $filename = 'qrcode_img.png';
        $path = './resource/img';
        $file = $path . "/" . $filename;
        echo "\$file = $file <br>";

        $qrcoderesult = "<br><img src=\"./resource/img/qrcode_img.png\"><br><H2>E-Voucher No : $instanceid </strong></H2>" . "<br>";
        echo $qrcoderesult;

        $htmlbody = " Your Mail Contant Here.... You can use html tags here...";

        $eol = PHP_EOL;

        $to = $recipient; //Recipient Email Address
        echo "To : $to <br>";
        $subject = "Value of RM $voucheramount E-voucher"; //Email Subject
        echo "subject : $subject <br>";
        $headers = "From: Ishin E-Voucher Generator " . $eol . "Reply-To: no-reply-ishin-evoucher@ishinevoucher.ddns.net" . $eol;

        $random_hash = md5(date('r', time()));

        $headers .= "Content-Type: multipart / mixed;
        boundary = \"PHP-mixed-" . $random_hash . "\"";
        echo "headers  : $headers  <br>";
        $filename = 'qrcode_img.png';
        $path = './resource/img';
        $file = $path . "/" . $filename;
        echo "\$file = $file <br>";
        $attachment = chunk_split(base64_encode(file_get_contents($file))); // Set your file path here
//define the body of the message.

        $message = "--PHP-mixed-$random_hash" . $eol . "Content-Type: multipart/alternative; boundary=\"PHP-alt-$random_hash\"" . $eol . $eol;
        $message .= "--PHP-alt-$random_hash" . $eol . $eol . "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n" . "Content-Transfer-Encoding: 7bit" . $eol . $eol;

//Insert the html message.
        $message .= $htmlbody;
        $message .= $eol . $eol . "--PHP-alt-$random_hash--" . $eol . $eol;

//include attachment
        $message .= "--PHP-mixed-$random_hash" . $eol . "Content-Type: application/zip; name=\"qrcode_img.png\"" . $eol . "Content-Transfer-Encoding: base64" . $eol . "Content-Disposition: attachment" . $eol . $eol;
        $message .= $attachment;
        $message .= "/r/n--PHP-mixed-$random_hash--";

//send the email
        $mail = mail($to, $subject, $message, $headers);

        echo $mail ? "Mail sent" : "Mail failed";
        /*
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
          file_put_contents($img_dir, $output); */
    }
} catch (Exception $ex) {
    $_SESSION['mailStat'] = 'error';
    $_SESSION['mailMsg'] = $ex->getMessage();
}
//echo '<META HTTP-EQUIV="refresh" content="0;URL=form_mailCustomer.php">'; //using META tags instead of headers because headers didn't work in PHP5.3

/**/