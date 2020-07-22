<?php

#include_once 'header.php';

if(isset($_SESSION['post'])){
    $postdata = $_SESSION['post'];
#    $customer_name = 'Joko Wi Dodo';
#    $voucheramount = 'RM 10';
#    $encode_ID = '696969696969696969';
    $customer_name = $postdata['customer_name'];
    $voucheramount = "RM".$postdata['radioRM'];
    $datecreate = $postdata['datecreate'];
    $expiredate = $postdata['expiredate'];
    $encode_ID = $postdata['encode_ID'];
}
?>
<div class="container">
    <table border='1' class="table table-bordered" style="align-self: center;max-width: 300px;margin:auto" >
        <tbody>
            <tr>
                <td colspan="2" style="">Thank you <?php echo $customer_name?></td>             
            </tr> 
            <tr>
                <td style='font-weight: bold;font-size: large'><?php echo $voucheramount; ?></td>
                <td style='text-align:right'><?php echo $encode_ID; ?></td>
            </tr>
            <tr style="text-align: center">
                <td colspan ='2' ><?php echo "<img src='cid:qrcode'/>"; ?></td>
            </tr>
            <tr>
                <td style='font-size: xx-small'><?php echo "Issued at :".$datecreate; ?></td>
                <td style='text-align: right;font-size: xx-small'><?php echo "Valid until : ".$expiredate; ?></td>
            </tr>
            <!--
            <tr>
                <td style="font: arial; text-align: center;vertical-align: center;align-content: center;width: 30%"><h2><b><?php #echo $voucheramount;?></b></h2></td>
                <td><?php# echo $encode_ID ?></td>
                <!--
                <td style="font: arial; text-align: center;vertical-align: center;align-content: center;width: 20%"><?php #echo "<img src='localhost/qrcode-and-email-evoucher-test/qrcodeimage.php?code=$encode_ID'/>" ?></td>                
                
                <td style="font: arial; text-align: center;vertical-align: center;align-content: center;width: 20%"><?php #echo "<img src='./qrcode_img.png'/>" ?></td>                
                -->
                <!--Adds image using embedded data from PHPMailer
                <td style="font: arial; text-align: center;vertical-align: center;align-content: center;width: 20%"><?php #echo "<img src='cid:qrcode'/>" ?></td> 
            </tr>
            -->
        </tbody>
    </table>
</div>