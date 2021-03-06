<?php

namespace voucher\Validate;

session_start();
include_once 'include/session.php';
include_once 'class/vouchergenerate.inc.php';

include_once 'class/dbh.inc.php';
include_once 'class/variables.inc.php';

use Dbh;
use SQL;
use Exception;

if (isset($_POST['submitSerialCode'])) {
    $postdata = $_POST;
    unset($_POST);
    $currentDate = date('Y-m-d H:i:s');
    $vouchertype = $postdata['vouchertype'];
    //check text size:
    $input = $postdata['serialcode'];
    preg_match('/(http:\/\/*)/', $input, $matches);
    if (!empty($matches)){
        //this is http link
        $cnLen = strlen($input) - 18;
        $inputSerialCode = substr($input,$cnLen);
    }else{
        //this is normal code
        $inputSerialCode = $input;
    }
    #echo "\$vouchertype = $vouchertype<br>";
    #echo "\$inputSerialCode = $inputSerialCode<br>";
} elseif (isset($_GET['qrscode'])) {
    $currentDate = date('Y-m-d H:i:s');
    $vouchertype = 'evoucher';
    $inputSerialCode = $_GET['qrscode'];
    #echo "\$vouchertype = $vouchertype<br>";
    #echo "\$inputSerialCode = $inputSerialCode<br>";
} else {

    die("Please try <a href='index.php'>again</a>.");
}

function fetchVoucherData($inputSerialCode, $vouchertype) {
    if ($vouchertype == 'evoucher') {
        $qr = "SELECT * FROM evoucher_serial WHERE instanceid = '$inputSerialCode'";
    } elseif ($vouchertype == 'preprintvoucher') {
        $qr = "SELECT * FROM preprint_serial WHERE runningno = '$inputSerialCode'";
    }
    #echo "\$qr = $qr <br>";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();

    return $result;
}

function updateRedeemVoid($vouchertype, $instanceid, $dateredeem, $updVoid) {
    if ($vouchertype == 'evoucher') {
        $table = 'evoucher_serial';
    } elseif ($vouchertype == 'preprintvoucher') {
        $table = 'preprint_serial';
    }
    $qr = "UPDATE $table SET "
            . "dateredeem = '$dateredeem', "
            . "void = '$updVoid' "
            . "WHERE instanceid = '$instanceid'";
    #echo "\$qr = $qr<br>";
    $objUpdSQL = new SQL($qr);
    $result = $objUpdSQL->getUpdate();
    if ($result == 'updated') {
        $info = 'Update Success';
    } else {
        $info = 'Update Fail';
    }
    return $info;
}

try {
    $result = fetchVoucherData($inputSerialCode, $vouchertype);
    #echo "List down array od \$result :-<br>";
    #print_r($result);
    #echo "<br>";
    if (!empty($result)) {
        #echo "Found data based on \$inputSerialCode = $inputSerialCode<br>";
        //check results
        $void = $result['void'];             // has void or not
        $expiredate = $result['expiredate']; // date of expiration
        $valvoucher = $result['valvoucher']; // the amount of the voucher
        $instanceid = $result['instanceid']; // exclusive instance id
        $currDate = date_format(date_create($currentDate), 'Y-m-d');

        //check if expired or not.
        if ($void != 'no') {
            #echo "voucher is void<br>";
            throw new Exception("Voucher has already been redeemed");
        } elseif ($currDate >= $expiredate) {
            #echo "Voucher has already expired<br>";
            $dateredeem = NULL;
            $updVoid = 'yes';
            $result = updateRedeemVoid($vouchertype, $instanceid, $dateredeem, $updVoid);
            throw new Exception("Voucher has already expired");
            //<-- do update Void into 'yes' here-->//
        } else {
            #echo "voucher is valid, redeeming......<br>";
            //<-- do update Void and Redeem here-->//
            $dateredeem = $currentDate;
            $updVoid = 'yes';
            $result = updateRedeemVoid($vouchertype, $instanceid, $dateredeem, $updVoid);
            #echo "\$result = $result<br>";
            if ($result == 'Update Success') {

                $_SESSION['VOUCHER_UPD_MSG'] = "Congratulation! You received RM" . $valvoucher . " discount!<br>"
                        . "Contact our staff for payment!";
            } else {
                throw new Exception('Failed to redeem, please contact administrator', (int) $inputSerialCode);
            }
        }
    } else {
        #echo "Cannot Found data based on \$inputSerialCode = $inputSerialCode<br>";
        throw new Exception("Voucher is not valid.");
    }
} catch (Exception $ex) {

    $_SESSION['VOUCHER_UPD_MSG'] = $ex->getMessage();
}
#echo $_SESSION['VOUCHER_UPD_MSG'];
echo '<META HTTP-EQUIV="refresh" content="0;URL=form_redeemVoucher.php">'; //using META tags instead of headers because headers didn't work in PHP5.3

