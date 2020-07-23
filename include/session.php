<?php

$lee_time = 1200; // 20minutes
if (!isset($_SESSION['activeUser'])) {
    //redirection link
    $_SESSION['redirectLocation'] = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    echo "<script>console.log('Debug Objects: SESSION redirectLocation =" . $_SESSION['redirectLocation'] . "' );</script>";
    die('You must login first, please <a href="login.php">login</a>');
} else {

    $startTimeout = $_SESSION['startTimeout'];
}

//check if exceeds lee time 
if (time() - $startTimeout > $lee_time) {
    include 'class/dbh.inc.php';
    include 'class/variables.inc.php';
    include 'class/session.inc.php';

    $objSESSIONS = new SESSIONS();
    $resultUpdSession = $objSESSIONS->endActiveSession($_SESSION['activeUID'], $_SESSION['activeUsername'], $_SESSION['googleCode']);

    //Session is timeout
    session_destroy();
    session_start();
    //redirection link
    $_SESSION['redirectLocation'] = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    echo "<script>console.log('Debug Objects: SESSION redirectLocation =" . $_SESSION['redirectLocation'] . "' );</script>";
    echo "Your session has expired. Click <a href='login.php'>here</a> to login again.";
    exit();
} else {
    $_SESSION['startTimeout'] = time();
}
?>