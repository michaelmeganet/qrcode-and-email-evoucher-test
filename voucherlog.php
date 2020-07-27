<?php
session_start();
include 'include/session.php';
include 'new-header.php';

if (isset($_GET['log'])){
    $logView = $_GET['log'];
}else{
    header('location: index.php');
}

switch ($logView){
    case 'EV':
        include_once 'voucherlog/evoucher_log.php';
        break;
    
    case 'PP':
        include_once 'voucherlog/preprintedvoucher_log.php';
        break;
    
    case 'log':
        include_once 'voucherlog/export_log.php';
        break;
}

include 'new-footer.php';
?>