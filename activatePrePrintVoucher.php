<?php
namespace voucher\PrePrint;
session_start();
include_once 'class/vouchergenerate.inc.php';

use Exception;
use PREPRINT_VOUCHER;


if(isset($_POST['submitActivate'])){
    #$rundate = (int)$_POST['rundate'];
    //create beginning no for running no
    #$crypt_rundate = pow($rundate,2);
    #$str_rundate = sprintf("%'.08d",$crypt_rundate);
    $userid = $_POST['userid'];
    $valvoucher = (int)$_POST['valvoucher'];
    $numStart = (int)$_POST['numStart'];
    $numEnd = (int)$_POST['numEnd'];
}else{
    die("Please try <a href='index.php'>again</a>.");
}

try {
    if($numEnd <= $numStart){
        throw new Exception("Batch number is invalid, End Value cannot exceed Begin Value");
    }else{
        $batchCount = ($numEnd - $numStart) + 1;
        $errorCount = 0;
        $arr_listFail = array();
        
        for ($i = 1; $i <= $batchCount; $i++){
            #$currNo = sprintf("%'.04d",($numStart + $i - 1));
            #$runningno = $str_rundate.$currNo;
            $currNo = $numStart + $i - 1;
            $runningno = sprintf("%'.010d",$currNo);
            #echo "No.$i : Processed runningno = $runningno<br>";
            $objVoucher = new PREPRINT_VOUCHER($userid, $valvoucher, $runningno);
            //create a voucher
            $createResult = $objVoucher->create_voucher();
            if ($createResult != 'Insert Successful!'){
                $errorCount += 1;
                $arr_listFail[] = array('runningno' => $runningno, 'message' => $createResult);
                    
            }
            #echo $createResult."<br>";
            #echo "-------------------------------------------------<br>";
        }
        $successCount = $batchCount - $errorCount;
        $_SESSION['prePrintCount'] = array('success'=>$successCount,'fail'=>$errorCount,'lastrunningno'=>$currNo);
        if($errorCount > 0){
            $_SESSION['arr_listFail'] = $arr_listFail;
        }
    }
} catch (Exception $exc) {
    $_SESSION['ERR_MSG'] = $exc->getMessage();
}

    echo '<META HTTP-EQUIV="refresh" content="0;URL=issue_preprintVoucher.php">'; //using META tags instead of headers because headers didn't work in PHP5.3

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

