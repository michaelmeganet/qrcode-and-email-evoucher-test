<?php
session_start();
include_once 'CRUD/CRUD-header.php';
include "include/session.php";
if (isset($_GET['view'])){
    $view = $_GET['view'];
}else{
    $view = 'main';
}

switch ($view) {
    case 'main':
        include_once('CRUD/CRUD-Main.php');

        break;
    
    case 'CC':
        include_once('CRUD/CRUD-CreateCustomer.php');

        break;
    
    case 'UC':
        include_once('CRUD/CRUD-UpdateCustomer.php');

        break;
    
    case 'RC':
        include_once('CRUD/CRUD-DetailsCustomer.php');

        break;
    
    case 'DC':
        include_once('CRUD/CRUD-DeleteCustomer.php');
        
        break;

    default:
        break;
}
?>

