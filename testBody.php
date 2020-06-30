<?php
include_once "header.php";
if($_SESSION['post']){
    $postdata = $_SESSION['post'];
    $vouchertype = $postdata['radioRM'];
}
?>

<div class='container'>
    <h4>Thank you for being a member of our Restaurant</h4>
    <br>
    We have provided you with voucher with amount of <?phpecho $vouchertype; ?><br>
    Please show the attached file to our staff for confirmation!
    
</div>
    