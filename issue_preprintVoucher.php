<?php

namespace voucher\PrePrint;

include_once 'header.php';
$month = date('m');
$year = date('y');
$rundate = $year . $month;
$numStart = 1;
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

    </head>
    <body>
        <div class='container'>
            <form action="activatePrePrintVoucher.php" method='POST'>
                <h3 class="text-primary">Activate Pre-Printed Vouchers (Batch)</h3>
                <!--
                    <div class='form-group row'>
                        <div class="col-sm-1">
                            <label class="label label-default">Running Date :</label><br>
                            <input class='form-control text-primary ' style="padding-right: 3px"type="text" name="rundate" value="<?php # echo $rundate;                                           ?>" readonly="readonly" />
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
                        <input class='form-control text-primary' <?php echo" value =\"$numStart\""; ?> style="text-align: center;padding-right: 3px;padding-left:3px;width:135%"type="text" name="numStart" id='numStart' value="" placeholder="0000000000" maxlength="10" />
                    </div>
                    <div class="col-sm-1 col-sm-pull-0">
                        <label class="label label-default">To :</label><br>
                        <input class='form-control text-primary ' style="text-align: center;padding-right: 3px;padding-left:3px;width:135%"type="text" name="numEnd" id='numEnd' value="" placeholder="9999999999" maxlength='10' />
                    </div>
                    <div class="col-sm-2">
                        <label class="label label-default">No. of vouchers :</label><br>
                        <select name='noQty' id='noQty' class="js-example-basic-single"
                                style="text-align: center;padding-right: 3px;padding-left:3px;width:120%" name="state"
                                onchange="getSelectOptionNo(this)">
                                    <?php
                                    for ($i = 1; $i < 10000; $i++) {
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                    ?>

                        </select>

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

        <script type="text/javascript" >
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
            $("#noQty").keyup(function() {

                var noQty = document.getElementById("noQty").value;

            });
        </script>
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