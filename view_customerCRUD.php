<?php
namespace CRUD\Customer;
include_once 'header.php';
require 'CRUD-functions.php';

$customerList = getCustomerList();
session_start();
if (isset($_SESSION['delMsg'])){
    $deleteResult = $_SESSION['delMsg'];
    session_destroy();
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
            <form action="index.php" method="post">
                <input class="button button-green mt-12 pull-right" type = "submit" name="reset_click" id="reset_click" value = "reset form">
            </form>
        <h3><b>Customer List CRUD</b></h3>
        <br>
        <?php
        if (isset($deleteResult)){
            ?>
        <div class='alert alert-info alert-dismissible fade in'>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $deleteResult;?> <br>
        </div>
            <?php
        }
        ?>
        <br>
            <div class="container form-group row">
                <div class=" form-group">
                    <a href="CRUD-CreateCustomer.php" class="btn btn-sm btn-primary">Create New Customer</a>
                </div>
                <table class="table table-bordered" style="overflow-y: auto;max-height: 400px;text-align: center">
                    <thead>
                        <tr style="">
                            <th style="width:10px;text-align: center">Id.</th>
                            <th style="width:20%;text-align: center">Customer.</th>
                            <th style="text-align: center">Address.</th>
                            <th style="width: 15%;text-align: center">Status</th>
                            <th style="width: 20%;text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($customerList as $customerData){
                                echo "<tr>";
                                
                                foreach($customerData as $key => $val){
                                    echo "<td>$val</td>";
                                }
                                ?>
                                <td>
                                    <a href="CRUD-DetailsCustomer.php?cid=<?php echo $customerData['cid']; ?>" class="btn btn-success">Details</a>
                                    <a href="CRUD-UpdateCustomer.php?cid=<?php echo $customerData['cid']; ?>" class="btn btn-info">Edit</a>
                                    <?php 
                                    echo "<a href=\"javascript:delValidate('CRUD-DeleteCustomer.php?cid={$customerData['cid']}','#')\" class='btn btn-danger'>Delete</a>";
                                    ?>
                                </td>
                                <?php
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
