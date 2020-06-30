<?php
include_once 'header.php';

if(isset($_SESSION['post'])){
    $postdata = $_SESSION['post'];
    #$customer_name = 'Joko Wi Dodo';
    #$voucheramount = 'RM 10';
    $customer_name = $postdata['customer_name'];
    $voucheramount = $postdata['radioRM'];
}
?>
<div class='container' style='max-width: 500px'>
    <table border='1' class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="3" style="">Thank you <?php echo $customer_name?></td>             
            </tr> 
            <tr>
                <td style="font: arial; text-align: center;vertical-align: center;align-content: center;width: 30%"><h2><b><?php echo $voucheramount;?></b></h2></td>
                <td><?php echo $encode_ID ?></td>
                <!--
                <td style="font: arial; text-align: center;vertical-align: center;align-content: center;width: 20%"><?php #echo "<img src='localhost/qrcode-and-email-evoucher-test/qrcodeimage.php?code=$encode_ID'/>" ?></td>                
                -->
                <td style="font: arial; text-align: center;vertical-align: center;align-content: center;width: 20%"><?php echo "<img src='./qrcode_img.png'/>" ?></td>                
                
            </tr> 
        </tbody>
    </table>
</div>