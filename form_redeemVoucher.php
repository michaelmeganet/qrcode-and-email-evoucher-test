<?php
namespace voucher\Validate;
include 'header.php';
$physvoucherRadio = '';
$evoucherRadio = '';

if(isset($_POST['vouchertype'])){
    $vouchertype = $_POST['vouchertype'];
    if($vouchertype=='evoucher'){
        $evoucherRadio = "checked='checked'";   
    }else{
        $physvoucherRadio = "checked='checked'";
    }
}
?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.\
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <body>
        <div class='container'>
            <h3 class="text-primary">Validate Voucher</h3>
            <form action="" method="POST">
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-5">
                        <label class="label label-default">Voucher Type :</label>
                        <div class='row-no-gutters'>
                            <label class=" radio-inline "><input type="radio" name="vouchertype" id='vouchertype' value="preprintvoucher" <?php echo $physvoucherRadio;?>/>Physical Voucher</label>
                            <label class=" radio-inline "><input type="radio" name="vouchertype" id='vouchertype' value="evoucher" <?php echo $evoucherRadio;?> />E-Voucher</label> 
                            <input class="inline btn btn-info " style="padding:3px 5px 3px 5px" type='submit' name='submitVoucherType' id='submitVoucherType' value='Select' />
                        </div>
                    </div>
                </div>
            </form>
        <?php
        if (isset($vouchertype)){
                ?>
            <form action='<?php echo "validateVoucher.php";?>' method="POST">
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-3">
                        <label class="label label-default">Scan QRCode or Type in here :</label>
                        <div class="row-no-gutters">
                            <input class=" form-control text-primary inline " type="input" name="serialcode" id="serialcode" value="" placeholder="Serial Code" />
                            <input class="inline btn btn-info btn-block" style=' align-self: center ' type="submit" name="submitSerialCode" id="submitSerialCode" value="Submit"/>
                        </div>
                    </div>
                </div>
                <input type='hidden' name='vouchertype' id='vouchertype' value="<?php echo $vouchertype; ?>" />
            </form>
                <?php
        }

        ?>
            
        </div>
        
        
    </body>
    </body>
</html>
