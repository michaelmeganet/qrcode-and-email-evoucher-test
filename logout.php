<?php
session_start();
include 'class/dbh.inc.php';
include 'class/variables.inc.php';
include 'class/session.inc.php';

$objSESSIONS = new SESSIONS();
$resultUpdSession = $objSESSIONS->endActiveSession($_SESSION['activeUID'], $_SESSION['activeUsername'], $_SESSION['googleCode']);


session_destroy();
header('location:login.php');
?>