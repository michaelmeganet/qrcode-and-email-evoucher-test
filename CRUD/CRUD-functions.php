<?php
namespace CRUD\Customer;

include_once 'class/dbh.inc.php';
include_once 'class/variables.inc.php';

use SQL;

function getLastCID(){
    $qr = "SELECT cid from customers ORDER BY cid DESC";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    $lastCID = $result['cid'];
    
    return $lastCID;
}

function getCustomerList(){
    $qr = "SELECT cid, cus_name, address1, status FROM customers ORDER BY cid";
    $objSQL = new SQL($qr);
    
    $result = $objSQL->getResultRowArray();
    return $result;
}

function getCustomerListDetail($cid){
    $qr = "SELECT * FROM customers WHERE cid = $cid ORDER BY cid";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    return $result;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

