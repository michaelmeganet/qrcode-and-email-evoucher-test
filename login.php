<?php

namespace AUTH\User;

session_start();
date_default_timezone_set("Asia/Jakarta");
#echo date('D-M-Y h:i:s');
if (isset($_POST['login'])) {
    include_once 'auth/AUTH-functions.php';
    $loginMsg = doLogin2($_POST);
    if ($loginMsg == 'login ok') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $authMode = 'yes';
    }
}

if (isset($_POST['auth'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $authMode = 'yes';
    include_once 'auth/AUTH-functions.php';
    $authMsg = doGoogleAuthCheck($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
    <!--   -->
    <head>
        <title>ISHIN Japanese Dining</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--https://en.wikipedia.org/wiki/Meta_refresh-->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>-->
        <script src='bower_components/jquery/dist/jquery.min.js'></script>

        <!-- SmartMenus core CSS (required) -->
        <link href="assets/css/sm-core-css.css" rel="stylesheet" type="text/css" />

        <!-- "sm-clean" menu theme (optional, you can use your own CSS, too) -->
        <link href="assets/css/sm-clean.css" rel="stylesheet" type="text/css" />

        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel='stylesheet' href='assets/bootstrap-3.3.7/bootstrap-3.3.7/dist/css/bootstrap.min.css'/>
        <link rel="stylesheet" href="assets/css/tooltip.css">
        <link rel="stylesheet" href="./assets/style.css">
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
        <script src='assets/bootstrap-3.3.7/bootstrap-3.3.7/dist/js/bootstrap.min.js'></script>
        <style type="text/css">
            body{background-color: #FFFFFF;}
            .form-login{
                width: auto;
                max-width: 350px;
                margin: auto auto;
                padding: 10px 20px;
                background: #DDDDDD;
                box-shadow: 2px 2px 4px #ab8de0;
                border-radius: 5px;
                color: #555555;
            }
            .form-login h3{
                margin-top: 0px;
                margin-bottom: 15px;
                padding-top: 5px;
                padding-bottom: 5px;
                border-radius: 10px;
                border: 0px solid #555555;
                background-color: white;
            }
            .form-login a{color: #555555;}
            .form-login a:hover{
                text-decoration: none;
                color: #555555;
            }
            .form-login .checkbox-inline{padding-top: 7px;}
        </style>

    </head>
    <!-- https://www.smartmenus.org/about/themes/ 
         Complete navbar .sm-clean -->

    <div class="container">
        <?php
        if (!isset($authMode)) {
            ?>
            <div class="form-login">
                <form action="" method="post" id='loginform' name='loginform'>
                    <!--<h2 class='text-center' style='border:0px'>Japanese Ishin Dining</h2>-->
                    <img src='assets/images/Ishin-logo.png' />
                    &nbsp;
                    <h3 class="text-center">Please login</h3>    
                    <?php
                    if (isset($loginMsg)) {
                        ?>
                        <div class="alert alert-danger alert-dismissible fade in" >
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:black;font-size:30px">&times;</a>
                            <h5><?php echo $loginMsg; ?></h5>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" required="required" name='username' class='username'>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" required="required" name='password' id='password'>
                    </div>
                    <div class="form-group clearfix" style='height:30px'>
                        <input type="submit" class="btn btn-primary pull-right btn-block" style=' font-size:20px' id='login' name='login' value='Log In'/>
                    </div>

                    <!-- Account Creation can only be done by administrator
                    <div class="clearfix">
                        <a href="#" class="pull-left">Forgot Password?</a>
                        <a href="#" class="pull-right">Create an Account</a>
                    </div>
                    -->
                </form>
            </div>
            <?php
        } else {
            if ($authMode == 'yes') {
                ?>
                <div class="form-login">
                    <form action="" method="post" id='loginform' name='loginform'>
                        <!--<h2 class='text-center' style='border:0px'>Japanese Ishin Dining</h2>-->
                        
                        <img src='assets/images/Ishin-logo.png' />
                        <?php
                        if (isset($authMsg)) {
                            ?>
                            <div class="alert alert-danger alert-dismissible fade in" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:black">&times;</a>
                                <?php echo $authMsg; ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div style="background-color:white;padding:4px 4px 4px 4px;border-radius: 5px;">

                            <h4 class="text-center text-info">Please enter your Authenticator Code</h4>  

                        </div>
                        <span>&nbsp;</span>
                        <div style="background-color:white;padding:15px 5px 5px 5px;border-radius: 5px">
                            <div class="form-group text-center">
                                <img src="assets/images/gAuth.png" style="width:200px"/>
                            </div>
                            <div class="form-group text-center ">
                                <input type="text" class="form-control " placeholder="000000" required="required" name='codeGoogle' id='codeGoogle' style="padding:20px 0px 20px 0px;width:100%;text-align:center;font-size:35px" />

                                        <!--<span class='ttiptext'>Google Authenticator can be found on your phone, Or contract your administrator</span>-->
                            </div>
                            <div class="form-group clearfix" style='height:30px'>

                                <input type='hidden' value='<?php echo $username; ?>' id='username' name='username'/>
                                <input type='hidden' value='<?php echo $password; ?>' id='password' name='password'/>
                                <input type='hidden' value='<?php echo $authMode; ?>' id='authMode' name='authMode'/>

                                <input type="submit" class="btn btn-primary pull-right btn-block" style=' font-size:20px' id='auth' name='auth' value='Log In'/>
                            </div>
                        </div>
                    </form>
                    <span>&nbsp;</span>
                    <div style='text-align: center'>

                        <a href='login.php' Class='btn btn-warning btn-mini btn-block'  >Go back to Login Page</a>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
