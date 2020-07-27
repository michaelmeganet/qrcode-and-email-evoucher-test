<?php
namespace CRUD\Customer\Details;
require 'CRUD-functions.php';
require 'CRUD/class/customer.inc.php';
use CUSTOMER;

if (isset($_GET['cid'])){
    $cid = $_GET['cid'];
    $post_data = \CRUD\Customer\getCustomerListDetail($cid);
    $objCustomer = new CUSTOMER($post_data);
    $deleteResult = $objCustomer->delete();
    $_SESSION['delMsg'] = $deleteResult;
    echo '<META HTTP-EQUIV="refresh" content="0;URL=CRUD-index.php?view=main">'; //using META tags instead of headers because headers didn't work in PHP5.3
}else{
    die('Cannot reach the page this way, <a href="CRUD-index.php?view=main">Please Try Again</a>.');
}

?>
