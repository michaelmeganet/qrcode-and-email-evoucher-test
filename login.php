<?php

namespace AUTH\User;

session_start();
date_default_timezone_set("Asia/Jakarta");
#echo date('D-M-Y h:i:s');
if (isset($_POST['login'])) {
    include_once 'auth/AUTH-functions.php';
    $loginMsg = doLogin($_POST);
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>

        <!-- SmartMenus core CSS (required) -->
        <link href="assets/css/sm-core-css.css" rel="stylesheet" type="text/css" />

        <!-- "sm-clean" menu theme (optional, you can use your own CSS, too) -->
        <link href="assets/css/sm-clean.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/tooltip.css">
        <link rel="stylesheet" href="./assets/style.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style type="text/css">
            body{background-color: #FFFFFF;}
            .form-login{
                width: 350px;
                margin: 120px auto;
                padding: 25px 20px;
                background: #DDDDDD;
                box-shadow: 2px 2px 4px #ab8de0;
                border-radius: 5px;
                color: #555555;
            }
            .form-login h3{
                margin-top: 0px;
                margin-bottom: 15px;
                padding-bottom: 5px;
                border-radius: 10px;
                border: 1px solid #555555;
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

        <div class="form-login">
            <form action="" method="post" id='loginform' name='loginform'>
                <h2 class='text-center' style='border:0px'>Japanese Ishin Dining</h2>
                &nbsp;
                <h3 class="text-center">Please login</h3>    
                <?php
                if (isset($loginMsg)) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade in" >
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:black">&times;</a>
                        <?php echo $loginMsg; ?>
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
                &nbsp;
                <div class="form-group">
                    <div class='text-left ttip' style='color:#555555'>6 Digit Authenticator Code :
                        <span class='ttiptext'>Use Google Auth App</span>
                    </div>
                    <input type="text" class="form-control" placeholder="000000" required="required" name='codeGoogle' id='codeGoogle'>
                </div>
                <div class="form-group clearfix">
                    <input type="submit" class="btn btn-primary pull-right" id='login' name='login' value='Log In'/>
                </div>

                <!-- Account Creation can only be done by administrator
                <div class="clearfix">
                    <a href="#" class="pull-left">Forgot Password?</a>
                    <a href="#" class="pull-right">Create an Account</a>
                </div>
                -->
            </form>
        </div>
    </div>
