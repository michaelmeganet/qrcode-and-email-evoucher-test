<?php

namespace voucher\EVoucher;

session_start();
if (isset($_SESSION['mailMsg'])) {
    $mailMsg = $_SESSION['mailMsg'];
    $mailStat = $_SESSION['mailStat'];
    unset($_SESSION['mailMsg']);
    unset($_SESSION['mailStat']);
}
include_once "include/session.php";
include_once 'new-header.php';

#echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'].$_SERVER['SCRIPT_FILENAME'];
$detected_ipaddress = $_SERVER['SERVER_NAME'];
#echo "THIS :> ".basename((__FILE__),'.php');
?>
<form action="index.php" method="post">
    <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
</form>
<div class ="container">
    <h3><b>Issue E-Voucher (Single)</b></h3>
    <br>
    <br>
    <?php
    if (isset($mailStat)) {
        if ($mailStat == 'success') {
            ?>            
            <label class="label label-success" style="font-size:12px">
                <?php
            } else {
                ?>
                <label class='label label-danger' style="font-size:12px">    
                    <?php
                }
                echo $mailMsg;
            }
            ?>
        </label>
        <span>&nbsp;</span>
        <form action='testMail.php' method='POST'>
            <div class="form-group row row-no-gutters">
                <div class="col-sm-1">                     
                    <label class="label label-default">User :</label><br> 
                    <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:auto"type="text" name="userid" id='userid' value="<?php echo $_SESSION['activeUsername']; ?>" placeholder="userid" maxlength="20" readonly />
                </div>
            </div>
<<<<<<< HEAD
        </div>
        <div class="form-group row row-no-gutters">
            <div class="col-sm-1">                     
                <label class="label label-default">Server IP Address :</label><br> 
                <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:auto"type="text" name="ipaddress" id='ipaddress' value="<?php echo $detected_ipaddress;?>" placeholder="<?php echo $detected_ipaddress;?>" maxlength="100" required="required"/>
                <label class="label label-warning">Please type in the IP Address of assigned Server.</label>
=======
            <div class="form-group row row-no-gutters">
                <div class="col-sm-1">                     
                    <label class="label label-default">Server IP Address :</label><br> 
                    <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:auto"type="text" name="ipaddress" id='ipaddress' value="" placeholder="<?php echo $detected_ipaddress; ?>" maxlength="20" required="required"/>
                    <label class="label label-warning">Please type in the IP Address of assigned Server.</label>
                </div>
>>>>>>> refs/remotes/origin/develop
            </div>
            <div class="form-group row">
                <div class='container'>
                    <label class="label label-default">Who to send?</label><br>
                </div>
                <div class="col-sm-3">
                    <input class='form-control text-primary' type="text" value ='' name='address' id='address' placeholder="who@address.com" required/>
                </div>
                <div class="col-sm-3">
                    <input class='form-control text-primary' type='text' value ='' name="customer_name" id='customer_name' placeholder="customer name" required/><br>
                </div>
            </div>
            <div class='container form-group row'>
                <label class='label label-default'>Voucher Type :</label>
                <label class='radio-inline'><input type='radio' name='radioRM' id='radioRM' value='5' checked="checked"/>RM 5</label>
                <label class='radio-inline'><input type='radio' name='radioRM' id='radioRM' value='10'/>RM 10</label>
            </div>
            <div class="container form-group row" style="text-align: right">
                <input class='btn btn-default' type='submit' value ='Send Mail' name="submitSendMail" id='submitSendMail'/><br>
            </div>

        </form>
</div>
<?php
include_once 'new-footer.php';
?>
</body>
