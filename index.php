<?php
session_start();
include "header.php";

if(isset($_POST['reset_click'])){
    session_destroy();
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a href ="form_mailCustomer.php">Generate an E-Voucher and E-Mail to Customer (done)</a>
        <br>
        <a href ="form_batchMailCustomer.php">Batch Generate many E-Vouchers and E-Mail to Customers (done)</a>
        <br>
        <a href ='importPreprintVoucher.php'>Activate pre-printed Voucher (done)</a>
        <br>
        <a href ='form_redeemVoucher.php'>Validate Voucher(done)</a>
        <?php
        
        ?>
    </body>
</html>
