<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel='stylesheet' href='assets/bootstrap-3.3.7/bootstrap-3.3.7/dist/css/bootstrap.min.css'/>
<script src='assets/bootstrap-3.3.7/bootstrap-3.3.7/dist/js/bootstrap.min.js'></script>
<?php
        include 'class/dbh.inc.php';
        include 'class/variables.inc.php';
        include 'class/session.inc.php';
$lee_time = 1200; // 20minutes
if (!isset($_SESSION['activeUser'])) {
    //redirection link
    $_SESSION['redirectLocation'] = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    echo "<script>console.log('Debug Objects: SESSION redirectLocation =" . $_SESSION['redirectLocation'] . "' );</script>";
    //die('You must login first, please <a href="login.php">login</a>');
    ?>
    <div class='container text-center' style='max-width: 350px;width:auto;margin:auto auto;' >
        <h3 class='text-primary ' style=''>You must login first</h3>
        <a href='login.php' class='btn btn-default'><h4>Go to login page.</h4></a>
    </div>
    <?php
    exit();
} else {

    $startTimeout = $_SESSION['startTimeout'];
    if (time() - $startTimeout > $lee_time) {

        $objSESSIONS = new SESSIONS();
        $resultUpdSession = $objSESSIONS->endActiveSession($_SESSION['activeUID'], $_SESSION['activeUsername'], $_SESSION['googleCode']);

        //Session is timeout
        session_destroy();
        session_start();
        //redirection link
        $_SESSION['redirectLocation'] = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        echo "<script>console.log('Debug Objects: SESSION redirectLocation =" . $_SESSION['redirectLocation'] . "' );</script>";
        echo ".";
        ?>
        <div class='container text-center' >
            <h3 class='text-primary'>Your session has expired.</h3>
            <a href='login.php' class='btn btn-default'><h4>Go to login page.</h4></a>
        </div>
        <?php
        exit();
    } else {
        $objSESSIONS = new SESSIONS();
        $_SESSION['startTimeout'] = time();
        $resultUpdTime = $objSESSIONS->updateActiveTime($_SESSION['activeUID'], $_SESSION['activeUsername'], $_SESSION['googleCode'], $_SESSION['startTimeout']);
    }
}

//check if exceeds lee time 
?>