<?php

include_once 'class/dbh.inc.php';
include_once 'class/variables.inc.php';
include_once 'class/phhdate.inc.php';
include_once 'IdGenerate.class.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function insertSQL($instancetid, $userid, $expiredate, $serialno, $datecreate) {
    $sqlInsert = "INSERT INTO serialtable SET instanceid = '$instancetid', "
            . " userid = '$userid', expiredate = '$expiredate' , serialno = '$serialno',"
            . " datecreate = '$datecreate';";
    #echo "$sqlInsert = $sqlInsert <br>";
    $objinsert = new SQL($sqlInsert);
    $result = $objinsert->InsertData();
    #echo "$result<br>";
}

function generate_runno($j) {
    $date = new DateTime();
    $date->setDate(2020, 10, 3);
//    echo $date->format('Y-m-d') . " | ";
    $expiredate = $date->format('Y-m-d');
    // $j = 1001; //only one user/machine ID
//    $datetimenow = time();
    $datecreate = date('Y-m-d H:i:s');

//    $datecreate = date("Y-m-d", strtotime($datetimenow));
//    echo "$datecreate " . "<br>";
    $serialno = 0;
//    $instantid = [];
        # code...
        //with in 100 time loop of $i

    $params = array('work_id' => $j,);
    $idGenerate = IdGenerate::getInstance($params);
    $instancetid = $idGenerate->generatorNextId();
    $serialno++;
    $sid = '';
    // return $id;
    // Prints the day, date, month, year, time, AM or PM
    insertSQL($instancetid, $j, $expiredate, $serialno, $datecreate);
    #echo "work_id = $j, \$instancetid = $instancetid    |   " . $datecreate . " | expireddate = $expiredate | $serialno<br>";
    // echo "work_id = $j, \$id = $id    |   " . date("l jS \of F Y h:i:s A") . " <br>";date_format($expiredate, 'd/m/Y');
    // sleep(1);

//    echo"<br>list down array \$instancetid<br>";
//    print_r($instancetid);
//    echo "<br>";
    return $instancetid;
}
