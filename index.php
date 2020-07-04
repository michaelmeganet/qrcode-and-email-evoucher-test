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
        <a href ="form_mailCustomer.php">Generate an E-Voucher and E-Mail to Customer</a>
        <br>
        <a href ='issue_PreprintVoucher.php'>Activate pre-printed Voucher </a>
        <br>
        <a href ='validate_Voucher.php'>Validate Voucher</a>
        <?php
        
        ?>
    </body>
</html>
