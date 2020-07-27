<?php
namespace CRUD\Customer\Update;
require 'CRUD-functions.php';
require 'CRUD/class/customer.inc.php';

use CUSTOMER;

if (isset($_POST['submitUpdate'])){
    $post_data = $_POST;
    $objCustomer = new CUSTOMER($post_data);
    $updateResult = $objCustomer->update();
}
if (isset($_GET['cid'])){
    $cid = $_GET['cid'];
    $customerDetail = \CRUD\Customer\getCustomerListDetail($cid);
    extract($customerDetail,EXTR_PREFIX_ALL,'dtl'); // extracts as $dtl_keyArray
}
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
        <title></title>
        <style>
            label.error{
                background-color: red;
                padding: 0px 3px 0px 3px;
                border-radius: 5px;
                font-family: 'Helvetica';
                font-size: 12px;
                color: white;
            }
        </style>
    </head>
    <body>
        
        <div class="container">
            <?php
            if(isset($updateResult)){
                if($updateResult == 'Update Successful'){
                    echo "<div class='alert alert-success alert-dismissible fade in'>";
                }else{
                    echo "<div class='alert alert-danger alert-dismissible fade in'>";                
                }
                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                echo "$updateResult<br>";
                echo "</div>";
            }
            ?>
            <form action="CRUD-index.php?view=main" method="post" >
                <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
            </form>
            <h3><b>Customer List CRUD</b></h3>
            <h4><b>Edit Customer</b></h4>
            <br>
            <form name='customerform' id='customerform' action='' method="POST" novalidate="novalidate">
                <div class="form-group row col-sm-4">
                    <label class="label label-default" style="font-size: 15px">ID</label>
                    <input class="form-control" style="max-width: 100px;text-align: right" type="text" id="cid" name="cid" value ="<?php echo $dtl_cid;?>" readonly/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Customer Name</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="cus_name" name="cus_name" value='<?php echo $dtl_cus_name;?>' placeholder="Customer Name" />
                    <br>
                    <label class="label label-default" style="font-size: 15px">Address</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address1" name="address1" value='<?php echo $dtl_address1;?>' placeholder="Address1" />
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address2" name="address2" value='<?php echo $dtl_address2;?>' placeholder="Address2" />
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address3" name="address3" value='<?php echo $dtl_address3;?>' placeholder="Address3" />
                    <br>
                    <label class="label label-default" style="font-size: 15px">Phone Number</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="phone" name="phone" value='<?php echo $dtl_phone;?>' placeholder="Phone Number" />
                    <br>
                    <label class="label label-default" style="font-size: 15px">Email</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="email" id="email" name="email" value='<?php echo $dtl_email;?>' placeholder="mail@address.com" />
                    <br>
                    <label class="label label-default" style="font-size: 15px">Status</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="status" name="status" value='<?php echo $dtl_status;?>' placeholder="Status" />
                    <br>
                    <div style='text-align:center'>
                        <input class='btn btn-primary btn-block' type='submit' value='Update' id='submitUpdate' name='submitUpdate'/>
                    </div>
                </div>
            </form>
        </div>
    <script src='CRUD/validation.js'></script>
    <?php include 'new-footer.php';?>
    </body>
</html>
