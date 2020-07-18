<?php
namespace CRUD\Customer\Details;
include_once 'header.php';
require 'CRUD-functions.php';
require 'customer.inc.php';
session_start();
use CUSTOMER;

if (isset($_GET['cid'])){
    $cid = $_GET['cid'];
    $post_data = \CRUD\Customer\getCustomerListDetail($cid);
    $objCustomer = new CUSTOMER($post_data);
    $deleteResult = $objCustomer->delete();
    $_SESSION['delMsg'] = $deleteResult;
    echo '<META HTTP-EQUIV="refresh" content="0;URL=view_customerCRUD.php">'; //using META tags instead of headers because headers didn't work in PHP5.3
}else{
    die('Cannot reach the page this way, <a href="view_customerCRUD.php">Please Try Again</a>.');
}

?>
