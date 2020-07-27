<?php

namespace voucher\Log;

require 'class/dbh.inc.php';
require 'class/variables.inc.php';

use SQL;

function getEVoucherListFilter($filterby = 'none', $filterval = 'none', $startLimit = 'none', $offset = 'none') {
    if ($filterby != 'none' && $filterval != 'none') {
        switch ($filterby) {
            case 'cusname':
                $whereClause = " WHERE cus_name LIKE '%$filterval%'";
                break;
            case 'user':
                $whereClause = " WHERE name LIKE '%$filterval%'";
                break;
        }
    } else {
        $whereClause = '';
    }
    #echo "startLimit = $startLimit, offset = $offset<br>";
    if ($startLimit !== 'none' && $offset !== 'none') {
        #echo "limit1<br>";
        $limitClause = "LIMIT $startLimit, $offset";
    } else {
        # echo "limit2<br>";
        $limitClause = '';
    }
    $qr = " SELECT sid, customers.cus_name, valvoucher, datecreate, expiredate, dateredeem, void, users.name FROM evoucher_serial
            LEFT JOIN customers
            ON customers.cid = evoucher_serial.cid
            LEFT JOIN users
            ON users.username = evoucher_serial.userid
            $whereClause  
             ORDER BY datecreate DESC 
            $limitClause";
    #echo "qr = $qr<br>";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    return $result;
}

function getPPVoucherListFilter($filterby = 'none', $filterval = 'none', $startLimit = 'none', $offset = 'none') {
    if ($filterby != 'none' && $filterval != 'none') {
        switch ($filterby) {
            case 'user':
                $whereClause = " WHERE name LIKE '%$filterval%'";
                break;
        }
    } else {
        $whereClause = '';
    }
    #echo "startLimit = $startLimit, offset = $offset<br>";
    if ($startLimit !== 'none' && $offset !== 'none') {
        #echo "limit1<br>";
        $limitClause = "LIMIT $startLimit, $offset";
    } else {
        # echo "limit2<br>";
        $limitClause = '';
    }
    $qr = " SELECT psid, runningno, valvoucher, datecreate, expiredate, dateredeem, void,users.NAME FROM preprint_serial
            LEFT JOIN users
            ON users.username = preprint_serial.userid
            $whereClause  
             ORDER BY datecreate DESC 
            $limitClause";
    #echo "qr = $qr<br>";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    return $result;
}

function countEVoucherListFilter($filterby = 'none', $filterval = '') {
    if ($filterby != 'none' && $filterval != '') {
        switch ($filterby) {
            case 'cusname':
                $whereClause = " WHERE cus_name LIKE '%$filterval%'";
                break;
            case 'user':
                $whereClause = " WHERE name LIKE '%$filterval%'";
                break;
        }
    } else {
        $whereClause = '';
    }
    $qr = " SELECT COUNT(*) FROM evoucher_serial
            LEFT JOIN customers ON customers.cid = evoucher_serial.cid
            LEFT JOIN users ON users.username = evoucher_serial.userid
            $whereClause  ";
    $objSQL = new SQL($qr);
    $result = $objSQL->getRowCount();
    return $result;
}

function countPPVoucherListFilter($filterby = 'none', $filterval = '') {
    if ($filterby != 'none' && $filterval != '') {
        switch ($filterby) {
            case 'user':
                $whereClause = " WHERE name LIKE '%$filterval%'";
                break;
        }
    } else {
        $whereClause = '';
    }
    $qr = " SELECT COUNT(*) FROM preprint_serial
            LEFT JOIN users ON users.username = preprint_serial.userid
            $whereClause  ";
    $objSQL = new SQL($qr);
    $result = $objSQL->getRowCount();
    return $result;
}
?>