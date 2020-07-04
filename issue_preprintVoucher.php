<?php
namespace voucher\PrePrint;
include_once 'header.php';
$month = date('m');
$year = date('y');
$rundate = $year.$month;
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
    </head>
    <body>
        <div class='container'>
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
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-1">                     
                        <label class="label label-default">User :</label><br> 
                        <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:135%"type="text" name="userid" id='userid' value="" placeholder="userid" maxlength="10" />
                    </div>
                </div>
                <div class="form-group row row-no-gutters">
                    <div class="col-sm-1">                     
                        <label class="label label-default">From :</label><br> 
                        <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:135%"type="text" name="numStart" id='numStart' value="" placeholder="0000000000" maxlength="10" />
                    </div>
                    <div class="col-sm-1 col-sm-pull-0">                     
                        <label class="label label-default">To :</label><br> 
                        <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:135%"type="text" name="numEnd" id='numEnd' value="" placeholder="9999999999" maxlength='10' />
                    </div>
                </div>
                <div>
                    <label class=" radio-inline "><input type="radio" name="valvoucher" id='valvoucher' value="5"/>RM 5</label>
                    <label class=" radio-inline "><input type="radio" name="valvoucher" id='valvoucher' value="10"/>RM 10</label>
                </div>
                <div>
                    <input class="btn btn-default"  type="submit" value="Activate Batch" name="submitActivate" id="submitActivate" />
                </div>
            </form>
        </div>
        <?php
        // put your code here
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