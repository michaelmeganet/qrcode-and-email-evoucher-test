<?php
namespace CRUD\Customer;
include_once 'header.php';
require 'CRUD-functions.php';
require 'customer.inc.php';

use CUSTOMER;

if (isset($_POST['submitCreate'])){
    $post_data = $_POST;
    $objCustomer = new CUSTOMER($post_data);
    $createResult = $objCustomer->create();
}

$lastCID = getLastCID();
$cid = $lastCID + 1;
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
            <?php
            if(isset($createResult)){
                if($createResult == 'Insert Successful'){
                    echo "<div class='alert alert-success alert-dismissible fade in'>";
                }else{
                    echo "<div class='alert alert-danger alert-dismissible fade in'>";                
                }
                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                echo "$createResult<br>";
                echo "</div>";
            }
            ?>
            <form action="view_customerCRUD.php" method="post">
                <input class="button button-green mt-12 pull-right" type = "submit" name="reset_click" id="reset_click" value = "Back to Main">
            </form>
            <h3><b>Customer List CRUD</b></h3>
            <h4><b>Create Customer</b></h4>
            <br>
            <form action='' method="POST">
                <div class="form-group row col-sm-4">
                    <label class="label label-default" style="font-size: 15px">ID</label>
                    <input class="form-control" style="max-width: 100px;text-align: right" type="text" id="cid" name="cid" value ="<?php echo $cid;?>" readonly/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Customer Name</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="cus_name" name="cus_name" value='' placeholder="Customer Name"/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Address</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address1" name="address1" value='' placeholder="Address1"/>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address2" name="address2" value='' placeholder="Address2"/>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="address3" name="address3" value='' placeholder="Address3"/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Email</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="email" name="email" value='' placeholder="E-Mail"/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Status</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="status" name="status" value='active' placeholder="Status"/>
                    <br>
                    <div style='text-align:center'>
                        <input class='btn btn-primary btn-block' type='submit' value='submit' id='submitCreate' name='submitCreate'/>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
