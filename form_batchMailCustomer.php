<?php

namespace voucher\EVoucherBatch;

session_start();
include "include/session.php";
include 'class/dbh.inc.php';
include 'class/variables.inc.php';
include 'new-header.php';

use SQL;

if (isset($_SESSION['mailResults'])) {
    $mailResults = $_SESSION['mailResults'];
    $mailCount = $_SESSION['mailCount'];
    $successCount = $mailCount['successCount'];
    $errCount = $mailCount['errCount'];
    unset($_SESSION['mailResults']);
    unset($_SESSION['mailCount']);
}
#if(isset($_POST['emailSelected'])){
#    $arr_email = $_POST['emailSelected'];
#    echo "<pre>";
#    print_r($arr_email);
#    echo "</pre>";
#}

function getCustomerList() {
    $qr = "SELECT * FROM customers ORDER BY cid";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    return $result;
}

$customerList = getCustomerList();
include 'header.php';

#echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'].$_SERVER['SCRIPT_FILENAME'];
#echo "THIS :> ".basename((__FILE__),'.php');
?>
<form action="index.php" method="post">
    <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
</form>
<div class ="container">
    <h3><b>Issue E-Voucher (Batch)</b></h3>
    <br>
    <br>
<?php
if (isset($mailCount)) {
    ?>
        <div class="alert alert-info alert-dismissible">

            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Done processing E-Voucher with <span style=" font-weight: bold;color: green"><?php echo $successCount; ?> successful process</span> and <span style="font-weight:bold;color:red"><?php echo $errCount; ?> failed process.</span><br>
            <p>Detail Failures :</p><br>
            <?php
            $postCount = 0;
            foreach ($mailResults as $rows) {
                if ($rows['mailStat'] == 'fail') {
                    $postCount++;
                    echo "$postCount. " . $rows['name'] . "(" . $rows['email'] . ") => <i>" . $rows['details'] . "</i><br>";
                }
            }
            ?>
        </div>

    <?php
}
?>
</label>
<form action='testMailBatch.php' method='POST'>
    <div class="form-group row row-no-gutters">
        <div class="col-sm-1">                     
            <label class="label label-default">User :</label><br> 
            <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:auto"type="text" name="userid" id='userid' value="" placeholder="userid" maxlength="10" />
        </div>
    </div>

    <div class='container form-group row' style="vertical-align: middle">
        <div class="col-sm-5">
            <label class='label label-default'>Voucher Type :</label>
            <label class='radio-inline'><input type='radio' name='radioRM' id='radioRM' value='5' checked="checked"/>RM 5</label>
            <label class='radio-inline'><input type='radio' name='radioRM' id='radioRM' value='10'/>RM 10</label>
        </div>
        <div class="col-sm-2 col-sm-push-5" style=" text-align: right">
            <input class='btn btn-default' type='submit' value ='Send Mail' name="submitSendMail" id='submitSendMail'/><br>                
        </div>
    </div>
    <div class="container form-group row" style="text-align: center">
        <table class="table table-responsive" style="overflow-y: auto;max-height: 400px">
            <thead>
                <tr>
                    <th>Id.</th>
                    <th>Customer.</th>
                    <th colspan="3" style="text-align: center">Address.</th>
                    <th>E-Mail.</th>
                    <th>Status</th>
                    <th style="width: 10px">Send Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($customerList as $customerData) {
                    echo "<tr>";
                    #$arr_emailSelected = array("name" => $customerData['cus_name'], "email" => $customerData['email']);
                    $emailSelected = $customerData['cus_name'] . "|x|" . $customerData['email'];
                    foreach ($customerData as $key => $val) {
                        echo "<td>$val</td>";
                    }
                    ?>
                <td><input type="checkbox" name="emailSelected[]" value="<?php echo $emailSelected; ?>" /></td>
    <?php
    echo "</tr>";
}
?>
            </tbody>
        </table>
    </div>

</form>
</div>
<?php
include 'new-footer.php';
?>