<?php

namespace AUTH\User\Update;

require 'AUTH-functions.php';

use USER;

if (isset($_POST['submitUpdate'])) {
    $post_uid = $_POST['uid'];
    $post_name = $_POST['name'];
    $post_username = $_POST['username'];
    $post_password = $_POST['password'];
    $post_credentials = $_POST['credentials'];
    $objUser = new \USER();
    $updateResult = $objUser->update($post_uid, $post_username, $post_name, $post_password, $post_credentials);
}
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $userDetail = \AUTH\User\getOneUser($uid);
    extract($userDetail, EXTR_PREFIX_ALL, 'dtl'); // extracts as $dtl_keyArray
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
            if (isset($updateResult)) {
                if ($updateResult == 'Update Successful') {
                    echo "<div class='alert alert-success alert-dismissible fade in'>";
                } else {
                    echo "<div class='alert alert-danger alert-dismissible fade in'>";
                }
                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                echo "$updateResult<br>";
                echo "</div>";
            }
            ?>
            <form action="AUTH-index.php?Aview=main" method="post" >
                <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
            </form>
            <h3><b>User List CRUD</b></h3>
            <h4><b>Edit User</b></h4>
            <br>
            <form name='userform' id='userform' action='' method="POST" novalidate="novalidate">
                <div class="form-group row col-sm-4">
                    <label class="label label-default" style="font-size: 15px">ID</label>
                    <input class="form-control" style="max-width: 100px;text-align: right" type="text" id="uid" name="uid" value ="<?php echo $dtl_uid; ?>" readonly/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Name</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="name" name="name" value='<?php echo $dtl_name; ?>' placeholder="Name"/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Username</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="username" name="username" value='<?php echo $dtl_username; ?>' placeholder="Username" />
                    <br>
                    <label class="label label-default" style="font-size: 15px">New Password</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="password" id="password" name="password" value='' placeholder=""/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Confirm Password</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="password" id="password_confirm" name="password_confirm" value='' placeholder=""/>
                    <br>
                    <label class="label label-default" style="font-size: 15px">Credentials</label>
                    <select class="form-control" style="max-width: 100%;text-align: left" id="credentials" name="credentials">
                        <option value="admin">Administrator</option>
                        <option value="staff" selected="selected">Staff Member</option>
                    </select>
                    <label class="label label-default" style="font-size: 15px">Active</label>
                    <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="active" name="active" value='<?php echo $dtl_active; ?>' placeholder="Active" readonly/>

                    <label class="label label-info" style="font-size: 15px">You cannot change active status,<br>&nbsp;&nbsp;Go to <a href='AUTH-index.php?Aview=AA'>Authenticator</a> to see this account's Google Code.</label>
                    <br>

                    <div style='text-align:center'>
                        <input class='btn btn-primary btn-block' type='submit' value='submit' id='submitUpdate' name='submitUpdate'/>
                    </div>

                </div>
            </form>
        </div>
        <script src='auth/validation.js'></script>
        <?php include 'new-footer.php'; ?>
    </body>
</html>
