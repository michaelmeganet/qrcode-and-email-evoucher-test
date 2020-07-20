<?php
namespace CRUD\Customer\Details;
require 'CRUD-functions.php';
require 'CRUD/class/customer.inc.php';

if (isset($_GET['cid'])){
    $cid = $_GET['cid'];
    $customerDetail = \CRUD\Customer\getCustomerListDetail($cid);
    extract($customerDetail,EXTR_PREFIX_ALL,'dtl'); //extracts the array as $dtl_keyArray
}else{
    die('Cannot reach the page this way, <a href="view_customerCRUD.php">Please Try Again</a>.');
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
    </head>
    <body>
        
        <div class="container">
            <form action="CRUD-index.php?view=main" method="post" >
                <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
            </form>
            <h3><b>Customer List CRUD</b></h3>
            <h4><b>Details Customer</b></h4>
            <br>
            <div class="form-group row col-sm-4">
                <label class="label label-default" style="font-size: 15px">ID</label>
                <input class="form-control" style="max-width: 100px;text-align: right" type="text" id="cid" name="cid" value ="<?php echo $dtl_cid;?>" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Customer Name</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="cus_name" name="cus_name" value='<?php echo $dtl_cus_name;?>' placeholder="Customer Name" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Address</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address1" name="address1" value='<?php echo $dtl_address1;?>' placeholder="Address1" readonly/>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address2" name="address2" value='<?php echo $dtl_address2;?>' placeholder="Address2" readonly/>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address3" name="address3" value='<?php echo $dtl_address3;?>' placeholder="Address3" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Phone Number</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="phone" name="phone" value='<?php echo $dtl_phone;?>' placeholder="Phone Number" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Email</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="email" name="email" value='<?php echo $dtl_email;?>' placeholder="address@mail.com" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Status</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="status" name="status" value='<?php echo $dtl_status;?>' placeholder="Status" readonly/>
                <br>
            </div>
                <div class='form-group row col-sm-4' style='text-align:left'>
                    <a href='CRUD-index.php?view=UC&cid=<?php echo $dtl_cid;?>' class='btn btn-success'>Edit Customer</a>
                </div>
        </div>
        <?php
            include 'new-footer.php';
       ?>
    </body>
</html>
