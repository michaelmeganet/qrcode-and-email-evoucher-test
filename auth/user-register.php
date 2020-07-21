<?php

namespace AUTH\User\Register;

require 'AUTH-functions.php';
require 'class/users.inc.php';
require 'googleLib/GoogleAuthenticator.php';

use USER;

if (isset($_POST['submitCreate'])) {
    $objGA = new \GoogleAuthenticator();
    $secret = $objGA->createSecret();
    $objUser = new USER();
    $createResult = $objUser->register($_POST['name'], $_POST['username'], $_POST['password'], $_POST['credentials'], $secret, 'yes');
}


$lastUID = \AUTH\User\getLastUID();
$UID = $lastUID + 1;
?>
<head>
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
        if (isset($createResult)) {
            if ($createResult == 'Insert Successful') {
                echo "<div class='alert alert-success alert-dismissible fade in'>";
            } else {
                echo "<div class='alert alert-danger alert-dismissible fade in'>";
            }
            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
            echo "$createResult<br>";
            echo "</div>";
        }
        ?>
        <h3 class="text-primary">Create New User</h3>
        <form name="userform" id='userform' action='' method="POST" novalidate="novalidate">
            <div class="form-group row col-sm-4">
                <label class="label label-default" style="font-size: 15px">ID</label>
                <input class="form-control" style="max-width: 100px;text-align: right" type="text" id="cid" name="cid" value ="<?php echo $UID; ?>" readonly/>
                <br>
                <label class="label label-default" style="font-size: 15px">Name</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="name" name="name" value='' placeholder="Your Name"/>
                <br>
                <label class="label label-default" style="font-size: 15px">User Name</label>
                <input class="form-control" style="max-width: 100%;text-align: left" type="text" id="username" name="username" value='' placeholder="Username"/>
                <br>
                <label class="label label-default" style="font-size: 15px">Password</label>
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
                <br>
                <div style='text-align:center'>
                    <input class='btn btn-primary btn-block' type='submit' value='submit' id='submitCreate' name='submitCreate'/>
                </div>
            </div>
        </form>
    </div>

    <script src='auth/validation.js'></script>
</body>