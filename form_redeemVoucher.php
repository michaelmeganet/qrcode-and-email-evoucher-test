<?php

namespace voucher\Validate;

session_start();
include 'header.php';
$physvoucherRadio = '';
$evoucherRadio = '';

if (isset($_POST['userid'])) {
    $userid = $_POST['userid'];
    unset($_POST['userid']);
}
if (isset($_POST['vouchertype'])) {
    $vouchertype = $_POST['vouchertype'];
    if ($vouchertype == 'evoucher') {
        $evoucherRadio = "checked='checked'";
    } else {
        $physvoucherRadio = "checked='checked'";
    }
}

if (isset($_SESSION['VOUCHER_UPD_MSG'])) {
    $voucherUpdMsg = $_SESSION['VOUCHER_UPD_MSG'];
    session_destroy();
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
                    <div class="col-sm-1">
                        <label class="label label-default">User :</label><br>
                        <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:auto"type="text" name="userid" id='userid' value="<?php if (isset($userid)) {
    echo $userid;
} ?>" placeholder="userid" maxlength="10" />
                    </div>
                </div>
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-5">
                        <label class="label label-default">Voucher Type :</label>
                        <div class='row-no-gutters'>
                            <label class=" radio-inline "><input type="radio" name="vouchertype" id='vouchertype' value="preprintvoucher" <?php echo $physvoucherRadio; ?>/>Physical Voucher</label>
                            <label class=" radio-inline "><input type="radio" name="vouchertype" id='vouchertype' value="evoucher" <?php echo $evoucherRadio; ?> />E-Voucher</label>
                            <input class="inline btn btn-info " style="padding:3px 5px 3px 5px" type='submit' name='submitVoucherType' id='submitVoucherType' value='Select' />
                        </div>
                    </div>
                </div>
            </form>
<?php
if (isset($vouchertype)) {
    ?>
                <form action='validateVoucher.php' method="POST">
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
if (isset($voucherUpdMsg)) {
    ?>
                <div class="form-group row row-no-gutters">
                    <label class="alert alert-block alert-dismissable"><?php echo $voucherUpdMsg; ?></label>
                </div>
    <?php
}
?>

        </div>


    </body>
</body>
</html>
