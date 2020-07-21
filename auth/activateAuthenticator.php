<?php

namespace AUTH\User\Activate;

require 'AUTH-functions.php';
require 'class/users.inc.php';
require 'googleLib/GoogleAuthenticator.php';

use USER;
use GoogleAuthenticator;

if (isset($_POST['submitSelect'])) {
    #echo 'clicked Select customer process<br>';
    $submitSelect = $_POST['submitSelect'];
    #print_r($_POST);
    #echo "<br>";
    $user = \AUTH\User\getOneUser($_POST['user']);
    extract($user, EXTR_PREFIX_ALL, 'user');
    $secret = $user_google_auth_code;
    $username = $user_username;
    if ($user_active == 'yes') {
        #echo "user is active<br>";
        $objGA = new GoogleAuthenticator();
        $qrCodeURL = $objGA->getQRCodeGoogleUrl($username, $secret, 'ISHIN JP DINING');
    } elseif ($user_active == 'no') {
        #echo "user is not active<br>";
        $_SESSION['authUsers'] = $_POST;
    }
}

if (isset($_POST['submitActivate'])) {
    #echo 'clicked Activate customer process<br>';
    $authUsers = $_SESSION['authUsers'];
    #print_r($authUsers);
    unset($_SESSION['authUsers']);
    $objGA = new GoogleAuthenticator();
    $secret = $objGA->createSecret();
    $active = 'yes';
    $objUser2 = new USER();
    $labelMsg = $objUser2->activate($authUsers['user'], $secret, $active);
}

if (isset($_POST['submitDeactivate'])) {
    #echo 'clicked Deactivate customer process<br>';
    $uid = $_POST['uid'];
    $objUser2 = new USER();
    $labelMsg = $objUser2->deactivate($uid);
}

$users_notActivated = \AUTH\User\getAllUser();
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
            <h3 class="text-primary">Connect to Authenticator</h3>
            <?php
            if (isset($labelMsg)) {
                ?>
                <div class="alert alert-info alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $labelMsg; ?>
                </div>
                <?php
            }
            ?>
            <div class='form-group row col-sm-4'>
                <form name="userform" id="userform" action='' method='POST'>
                    <label class="label label-default" style="font-size: 15px">Select User </label>
                    <select class="form-control" style="max-width: 100%;text-align: left" id="user" name="user">
                        <?php
                        foreach ($users_notActivated as $rows) {
                            $value = $rows['uid'];
                            $label = $rows['username'];
                            echo "<option value='$value'>$label</option>";
                        }
                        ?>
                    </select>
                    &nbsp;
                    <input class='btn btn-primary btn-block inline' type='submit' value='Activate Authenticator' id='submitSelect' name='submitSelect'/>
                </form>

            </div>
            <?php
            if (isset($submitSelect)) {
                if ($user_active == 'yes') {
                    ?>
                    <div class='form-group row col-sm-5 col-sm-push-1' style ='text-align: center'>
                        <label class="label label-default" style="font-size:15px">Name</label>
                        <label class="label label-info" style="font-size:15px"><?php echo $user_name; ?></label>
                        <br>
                        <br>
                        <label class="label label-default" style="font-size:15px">User Name</label>
                        <label class="label label-info"style="font-size:15px"><?php echo $user_username; ?></label>
                        <br>
                        <br>
                        <h4 class="text-primary"><strong>Please scan the below QRCode on your Google Authenticator App</strong></h4>
                        <img src="<?php echo $qrCodeURL; ?>"/>
                        <div style="text-align:center">
                            <h4>Get Google Authenticator on your phone</h4>
                            <a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank"><img class='app' src="assets/images/iphone.png" style="width:120px" /></a>

                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank"><img class="app" src="assets/images/android.png" style="width:120px" /></a>
                        </div>
                        <br>
                        <div style='text-align: center'>
                            <form id='deactivate' name='deactivate' method='post' action=''>
                                <input type='hidden' id='uid' name='uid' value='<?php echo $user_uid; ?>' />
                                <input class='btn btn-danger' id='submitDeactivate' name='submitDeactivate' type='submit' value='Deactivate This Account'/>
                                <h5>(this will disable the current QRCode, You need to Activate it again to use this account)</h5>
                            </form>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class='form-group row col-sm-5 col-sm-push-1' style ='text-align: center'>
                        <form action='' name='activateuser' id='activateuser' method='POST'>

                            <label class='alert alert-info block'>User is not activated yet</label> <br>
                            <input class='btn btn-default'  id='submitActivate' name='submitActivate' type='submit' value='Click here to activate'/>
                        </form>
                    </div>
                    <?PHP
                }
            }
            ?>
        </div>
    </body>
</html>
