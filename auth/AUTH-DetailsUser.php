<?php
namespace AUTH\User\Details;
require 'AUTH-functions.php';

if (isset($_GET['uid'])){
    $uid = $_GET['uid'];
    $userDetail = \AUTH\User\getOneUser($uid);
    extract($userDetail,EXTR_PREFIX_ALL,'dtl'); //extracts the array as $dtl_keyArray
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
            <form action="AUTH-index.php?Aview=main" method="post" >
                <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
            </form>
            <h3><b>User List CRUD</b></h3>
            <h4><b>Details User</b></h4>
            <br>
            <div class="form-group row col-sm-4">
                <label class="label label-default" style="font-size: 15px">ID</label>
                <input class="form-control" style="max-width: 100px;text-align: right" type="text" id="uid" name="uid" value ="<?php echo $dtl_uid;?>" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Name</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="name" name="name" value='<?php echo $dtl_name;?>' placeholder="Name" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Username</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="username" name="username" value='<?php echo $dtl_username;?>' placeholder="Username" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Credentials</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="credentials" name="credentials" value='<?php echo $dtl_credentials;?>' placeholder="Credentials" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Active</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="active" name="active" value='<?php echo $dtl_active;?>' placeholder="Active" readonly/>
                <br>
                <?php
                if ($dtl_active == 'yes'){
                    ?>
                <label class="label label-info" style="font-size: 15px">This account is active, Go to <a href='AUTH-index.php?Aview=AA'>Authenticator</a> to see this account's Google Code.</label>
                <br>
                
                <?php
                }else if ($dtl_active == 'no'){
                    ?>
                <label class="label label-info" style="font-size: 15px">This account is not activated, Go to <a href='AUTH-index.php?Aview=AA'>Authenticator</a> to activate it.</label>
                <br>
                <?php
                }
                ?>
            </div>
                <div class='form-group row col-sm-4' style='text-align:left'>
                    <a href='AUTH-index.php?Aview=UU&uid=<?php echo $dtl_uid;?>' class='btn btn-success'>Edit User</a>
                </div>
        </div>
        <?php
            include 'new-footer.php';
       ?>
    </body>
</html>
