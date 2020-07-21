<?php
namespace CRUD\Customer;
require 'CRUD-functions.php';

$customerList = getCustomerList();
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
                <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
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
                    <a href="CRUD-index.php?view=CC" class="btn btn-sm btn-primary">Create New Customer</a>
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
                                    <a href="CRUD-index.php?view=RC&cid=<?php echo $customerData['cid']; ?>" class="btn btn-success">Details</a>
                                    <a href="CRUD-index.php?view=UC&cid=<?php echo $customerData['cid']; ?>" class="btn btn-info">Edit</a>
                                    <?php 
                                    #jscript is on header.php, Show alertbox to confirm decision
                                    echo "<a href=\"javascript:delValidate('CRUD-index.php?view=DC&cid={$customerData['cid']}','#')\" class='btn btn-danger'>Delete</a>";
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
       <?php
            include 'new-footer.php';
       ?>
    </body>
</html>
