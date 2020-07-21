<?php
namespace AUTH\User;

include 'class/dbh.inc.php';
include 'class/variables.inc.php';

use SQL;

function getLastUID(){
    $qr = 'SELECT * FROM users ORDER BY uid DESC';
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    $lastUID = $result['uid'];
    
    return $lastUID;
}

function getAllUser(){
    $qr = 'SELECT * FROM users ORDER BY uid DESC';
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    return $result;
}

function getOneUser($uid){
    $qr = "SELECT * FROM users WHERE uid = $uid ORDER BY uid DESC";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    return $result;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

