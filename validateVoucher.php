<?php
namespace voucher\Validate;
include_once 'class/vouchergenerate.inc.php';

if (isset($_POST)){
    $postdata = $_POST;
    unset ($_POST);
    $vouchertype = $postdata['vouchertype'];
    $inputSerialCode = $postdata['serialcode'];
    
    echo "\$vouchertype = $vouchertype<br>";
    echo "\$inputSerialCode = $inputSerialCode<br>";
    
}