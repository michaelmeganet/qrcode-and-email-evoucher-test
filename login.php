<?php
date_default_timezone_set("Asia/Jakarta");
echo date('D-M-Y h:i:s');
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $codeGoogle = $_POST['codeGoogle'];
    echo "\$username = $username,  \$password = $password, \$hash = ".hash('sha256',$password).",  \$codeGoogle = $codeGoogle<br>";
    include_once 'class/dbh.inc.php';
    include_once 'class/variables.inc.php';
    include_once 'class/users.inc.php';

    $objUser0 = new USER();
    $loginResult = $objUser0->login($username, $password);
    if ($loginResult == 'User Correct') {
        echo "user is correct<br>";
        //the user is found, check if active or not
        $user_active = $objUser0->get_active();
        if ($user_active == 'yes') {
            echo "user is active<br>";
            //user is active, check google code
            include_once 'auth/googleLib/GoogleAuthenticator.php';
            $user_secret = $objUser0->get_google_auth_code();
            echo "\$user_secret = $user_secret<br>";
            $objGA = new GoogleAuthenticator();
            $checkAuth = $objGA->verifyCode($user_secret, $codeGoogle, 2); // userAuth code, 6 digit code, 2 * 30 sec tolerance
            if ($checkAuth) {
                echo "Google auth is complete<br>";
                $_SESSION['googleCode'] == $codeGoogle;
                $_SESSION['activeUser'] == $username;
                header('Location: index.php');
            }else{
                echo "Google auth is wrong<br>";
                $loginMsg = 'The 6 digit code is not valid';
            }
        } else {
            echo "user is not active<br>";
            $loginMsg = 'User is not yet activated, Contact administrator';
        }
    } else {
        echo "wrong username / password<br>";
        $loginMsg = $loginResult;
    }
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

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/tooltip.css">
        <link rel="stylesheet" href="./assets/style.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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
                    <div class="alert alert-info alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
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
