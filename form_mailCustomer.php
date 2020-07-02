<?php
session_start();
if(isset($_SESSION['mailMsg'])){
    $mailMsg = $_SESSION['mailMsg'];
    $mailStat = $_SESSION['mailStat'];
    session_destroy();
}
include 'header.php';   

#echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'].$_SERVER['SCRIPT_FILENAME'];

#echo "THIS :> ".basename((__FILE__),'.php');
?>
<div class ="container">
    <h3><b>INSERT TITLE HERE</b></h3>
    <br>
    <br>
    <?php
        if(isset($mailStat)){
            if($mailStat == 'success'){
            ?>            
            <label class="label label-success">
            <?php
            }else{
            ?>
            <label class='label label-danger'>    
            <?php
            }
        echo $mailMsg;
        }
    ?>
    </label>
    <form action='testMail.php' method='POST'>
        <div class="form-group row">
            <div class='container'>
                <label class="label label-default">Who to send?</label><br>
            </div>
            <div class="col-sm-3">
                <input class='form-control text-primary' type="text" value ='who@address.com' name='address' id='address'/>
            </div>
            <div class="col-sm-3">
                <input class='form-control text-primary' type='text' value ='customer name' name="customer_name" id='customer_name'/><br>
            </div>
        </div>
        <div class='container form-group row'>
            <label class='label label-default'>Voucher Type :</label>
            <label class='radio-inline'><input type='radio' name='radioRM' id='radioRM' value='5'/>RM 5</label>
            <label class='radio-inline'><input type='radio' name='radioRM' id='radioRM' value='10'/>RM 10</label>
        </div>
        <div class="container form-group row" style="text-align: right">
            <input class='btn btn-default' type='submit' value ='Send Mail' name="submitSendMail" id='submitSendMail'/><br>
        </div>
        
    </form>
</div>