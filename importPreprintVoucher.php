<?php
namespace voucher\PrePrint;
session_start();
include "include/session.php";
include_once 'new-header.php';
include_once 'class/dbh.inc.php';
include_once 'class/variables.inc.php';

use SQL;

$month = date('m');
$year = date('y');
$rundate = $year.$month;

if (isset($_SESSION['ERR_MSG'])){
    $err_msg = $_SESSION['ERR_MSG'];
    unset($_SESSION['ERR_MSG']);
}
if (isset($_SESSION['prePrintCount'])){
    $prePrintCount = $_SESSION['prePrintCount'];
    $successCount = $prePrintCount['success'];
    $failCount = $prePrintCount['fail'];
    $lastrunningno = $prePrintCount['lastrunningno'];
    unset($_SESSION['prePrintCount']);
}
if(isset($_SESSION['arr_listFail'])){
    $arr_listFail = $_SESSION['arr_listFail'];
    unset($_SESSION['arr_listFail']);
}

function getLastRunningNo(){
    $qr = "SELECT * FROM preprint_serial ORDER BY runningno DESC";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    $lastRunNo = (float)$result['runningno'];
    
    return $lastRunNo;
}

$lastRunNo = getLastRunningNo();
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
        <title>Activate Batch</title>
        <script src="./assets/jquery-2.1.1.min.js"></script>
        <link href="bower_components/select2/dist/css/select2.min.css" rel="stylesheet" />
        <script src="bower_components/select2/dist/js/select2.min.js"></script>
        
    </head>
        
        <div class='container'>
            <form action="index.php" method="post">
                <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
            </form>
            <form action="activatePrePrintVoucher.php" method='POST'>
            <h3 class="text-primary">Activate Pre-Printed Vouchers (Batch)</h3>
            <!--
                <div class='form-group row'>
                    <div class="col-sm-1">                     
                        <label class="label label-default">Running Date :</label><br> 
                        <input class='form-control text-primary ' style="padding-right: 3px"type="text" name="rundate" value="<?php# echo $rundate; ?>" readonly="readonly" />
                    </div>
                </div>  
            -->
            <?php
            if (isset($prePrintCount)){
            ?>
                <div class="form-group row row-no-gutters">
                    <label class="label label-success">
                    <?php
                    echo "Successfully processed $successCount items.";    
                    ?>   
                    </label>
                    <?php
                    if ($failCount > 0){
                        ?>
                        <label class="label label-danger">Failed to process <?php echo $failCount;?> items.</label>
                        <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            <?php
            if (isset($err_msg)){
            ?>
                <div class="alert alert-dismissable">
                    <label class="label label-danger"><?php echo $err_msg;?></label>
                       
                </div>
            <?php
            }
            ?>
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-1">                     
                        <label class="label label-default">User :</label><br> 
                        <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:auto"type="text" name="userid" id='userid' value="<?php echo $_SESSION['activeUsername'];?>" placeholder="userid" maxlength="20" readonly />
                    </div>
                </div>
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-1">                     
                        <label class="label label-primary">Last procesed Runningno : <?php echo sprintf("%'.010d",$lastRunNo);?></label><br> 
                    </div>
                </div>
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-2">
                        <label class="label label-default">No. of vouchers :</label><br>
                        <select name='noQty' id='noQty' class="js-example-basic-single"
                                style="text-align: center;padding-right: 3px;padding-left:3px;width:100%" name="state"
                                onchange="getSelectOptionNo(this)">
                                    <?php
                                    for ($i = 1; $i < 1000; $i++) {
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                    ?>

                        </select>

                    </div>
                </div>
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-2">                     
                        <label class="label label-default">From :</label><br> 
                        <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:100%"type="text" name="numStart" id='numStart' value="<?php echo $lastRunNo+1;?>" placeholder="0000000000" maxlength="10" />
                    </div>
                    <div class="col-sm-2 col-sm-pull-0">                     
                        <label class="label label-default">To :</label><br> 
                        <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:100%"type="text" name="numEnd" id='numEnd' value="<?php echo $lastRunNo+2;?>" placeholder="9999999999" maxlength='10' />
                    </div>
                    
                </div>
                <div>
                    <label class=" radio-inline "><input type="radio" name="valvoucher" id='valvoucher' value="5" checked="checked"/>RM 5</label>
                    <label class=" radio-inline "><input type="radio" name="valvoucher" id='valvoucher' value="10"/>RM 10</label>
                </div>
                <div>
                    <input class="btn btn-default"  type="submit" value="Activate Batch" name="submitActivate" id="submitActivate" />
                </div>
            </form>
            <?php
            if(isset($arr_listFail)){
            ?>
            <div class="form-group row row-no-gutters">
                <div class="col-sm-7 col-sm-pull-0">
                    <label class="label label-info">Details :</label>
                    <textarea class="form-control" rows="8" name="listFail" id="listFail" style="overflow-y: scroll">
                        <?php
                        foreach($arr_listFail as $rows){
                            echo "&#13;&#10;".$rows['runningno']." ==> ".$rows['message'];   
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <?php
            }
            #include 'new-footer.php';
            ?>
            <script type="text/javascript">
                function getSelectOptionNo(sel) {

                    var tmp = sel.options[sel.selectedIndex].text;
                    var tmp2 = sel.options[sel.selectedIndex].value;
    //                $('#numStart').val(tmp);
    //                $('#numStart').val(tmp);
                    var numStart = document.getElementById('numStart').value;
                    var start = parseFloat(numStart);
                    var noInteger = parseFloat(tmp);
                    console.log("start = " + start);
                    console.log("noInteger = " + noInteger);
                    var numEnd = start + noInteger - 1;
                    $('#numEnd').val(numEnd);
                    console.log(numEnd);

                    //document.getElementById("Thick").value = cars;
    //    alert(tmp);
                    //console.log(tmp);

                }
            </script>
            <script type="text/javascript" >
                $(document).ready(function() {
                    $('.js-example-basic-single').select2();
                });
                $("#noQty").keyup(function() {

                    var noQty = document.getElementById("noQty").value;

                });
            </script>
        </div>
        <?php
        include 'new-footer.php';
        ?>
    </body>
</html>


<!--
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

-->