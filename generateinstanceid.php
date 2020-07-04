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
class CREATE_VOUCHER{
    protected $instanceid;
    protected $userid;
    protected $valvoucher;
    protected $datecreate;
    protected $expiredate;
    
    
    function __construct($userid,$valvoucher,$datecreate) {
        $this->set_userid($userid);
        $this->set_valvoucher($valvoucher);
        $this->set_datecreate($datecreate);
        //expiration date is 2 Months from now
        $expiredate = date_format(date_add(date_create($datecreate), date_interval_create_from_date_string("+2 Months")),"Y-m-d");
        $this->set_expiredate($expiredate);
        
        $instanceid = $this->generate_instanceid();
        $this->set_instanceid($instanceid);        
    }
    
    function generate_instanceid() { //$j = $userid
        $j = $this->get_userid();
        #$valvoucher = $this->get_valvoucher();
        #$expiredate = $this->get_expiredate();
        #$datecreate = $this->get_datecreate();
        #$serialno = $this->get_serialno();
        
        $params = array('work_id' => $j,);
        $idGenerate = IdGenerate::getInstance($params);
        $instanceID = $idGenerate->generatorNextId();
        return $instanceID;
        
    }
    
    function set_instanceid($input){
        $this->instanceid = $input;
    }
    
    function get_instanceid(){
        return $this->instanceid;
    }
    
    function set_userid($input){
        $this->userid = $input;
    }
    
    function get_userid(){
        return $this->userid;
    }
    
    function set_valvoucher($input){
        $this->valvoucher = $input;
    }
    
    function get_valvoucher(){
        return $this->valvoucher;
    }
    
    function set_datecreate($input){
        $this->datecreate = $input;
    }
    
    function get_datecreate(){
        return $this->datecreate;
    }
    
    function set_expiredate($input){
        $this->expiredate = $input;
    }
    
    function get_expiredate(){
        return $this->expiredate;
    }
    
    
}

Class PREPRINT_VOUCHER extends CREATE_VOUCHER{
    protected $runningno;
    protected $serialno;
    protected $void = 'no'; //default value = no
    protected $table = 'preprint_serial';
   
    function __construct($userid, $valvoucher, $datecreate, $runningno) {
        parent::__construct($userid, $valvoucher, $datecreate);
        $this->set_runningno($runningno);
        $lastSerialNo = $this->fetchLastSerialNo();///serialno format = int
        echo "\$lastSerialNo = $lastSerialNo<br>";
        $serialno = $lastSerialNo + 1; //initialize serialno;
        echo "\$serialno = $serialno<br>";
        $this->set_serialno($serialno);
                
    }
    
    function create_voucher(){
        //check if the runningno available or not
            $inf_checkRunningNo = $this->checkRunningNo();
            if($inf_checkRunningNo == 'runno avail'){
                //runningno available, can create new voucher
                $result = $this->insertSQL();
            }else{
                //runningno not available, check if voucher valid or not
                $inf_checkExpiryDate = $this->checkExpiryDate();
                $inf_checkVoid = $this->checkVoid();
                if (($inf_checkExpiryDate == 'voucher expired') || ($inf_checkVoid == 'voucher void')){
                    //voucher is not valid, can create new voucher
                    $result = $this->insertSQL();
                }else{
                    //voucher is still valid, runningno cannot be used,
                    $result = "Runningno already active, please check<br>";
                }
            }
            return $result;
    }
    
    function insertSQL(){
        //columns : runningno, instanceid, userid, valvoucher, expiredate, serialno, datecreate, dateredeem, void;
        $table = $this->get_table();
        $runningno = $this->get_runningno();
        $instanceid = $this->get_instanceid();
        $userid = $this->get_userid();
        $valvoucher = $this->get_valvoucher();
        $expiredate = $this->get_expiredate();
        $serialno = $this->get_serialno();
        $datecreate = $this->get_datecreate();
        //create post array
        $bindparamArray = array(
                            'runningno'=>$runningno,
                            'instanceid'=>$instanceid,
                            'userid'=>$userid,
                            'valvoucher'=>$valvoucher,
                            'expiredate'=>$expiredate,
                            'serialno'=>$serialno,
                            'datecreate'=>$datecreate
                        );
        
        $qr = "INSERT INTO $table SET "
                . "runningno=:runningno, "
                . "instanceid=:instanceid, "
                . "userid=:userid, "
                . "valvoucher=:valvoucher, "
                . "expiredate=:expiredate, "
                . "serialno=:serialno, "
                . "datecreate=:datecreate ";
        $objSQL = new SQLBINDPARAM($qr, $bindparamArray);
        $result = $objSQL->InsertData2();
        if($result == 'insert ok!'){
            $info = 'Insert Successful!';
        }else{
            $info = 'Insert Failed';
        }
        return $info;
        
    }
    
    function fetchLastSerialNo(){
        $table = $this->get_table();
        $qr = "SELECT * FROM $table ORDER BY serialno DESC";
        
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if (!empty($result)){
            $lastSerialNo = $result['serialno'];
        }else{
            $lastSerialNo = 0;
        }
        return $lastSerialNo;
    }
    
    function checkRunningNo(){
        $table = $this->get_table();
        $runningno = $this->get_runningno();
        $qr = "SELECT * FROM $table WHERE runningno = $runningno ORDER BY serialno DESC;";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        
        if (empty($result)){
            echo "Running no has not been used<br>";
            $info = 'runno avail';
        }else{
            echo "Running no has been used<br>";
            $info = 'runno not avail';
        }
        return $info;
    }
    
    function checkExpiryDate(){
        $table = $this->get_table();
        $currDate = date_format(date_create($this->get_datecreate()),'Y-m-d');
        echo "\$currDate = $currDate<br>";
        $runningno = $this->get_runningno();
        $qr = "SELECT * FROM $table WHERE runningno = $runningno ORDER BY serialno DESC;";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if ($currDate >= $result['expiredate']){
            echo "Voucher has expired <br>";
            $info = 'voucher expired';
            
        }else{
            echo "Voucher still active<br>";
            $info = 'voucher not expired';
        }
        return $info;          
    }
    
    function checkVoid(){
        $table = $this->get_table();
        $runningno = $this->get_runningno();
        $qr = "SELECT * FROM $table WHERE runningno = $runningno ORDER BY serialno DESC";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if($result['void'] == 'no'){
            echo "Voucher not void<br>";
            $info = 'voucher not void';
        }else{
            echo "Voucher void<br>";
            $info = 'voucher void';
        }
        return $info;
    }
     
    function get_runningno(){
        return $this->runningno;
    }
    
    function set_runningno($input){
        $this->runningno = $input;
    }
    
    function get_serialno(){
        return $this->serialno;
    }
    
    function set_serialno($input){
        $this->serialno = $input;
    }
    
    function get_void(){
        return $this->void;
    }
    
    function set_void($input){
        $this->void = $input;
    }
    
    function get_table(){
        return $this->table;
    }
    
    function set_table($input){
        $this->table = $input;
    }
    
}

function insertSQL($instancetid, $userid, $expiredate, $serialno, $datecreate, $valvoucher) {
    $sqlInsert = "INSERT INTO serialtable SET "
            . "instanceid = '$instancetid', "
            . "userid = '$userid', "
            . "valvoucher = '$valvoucher', "
            . "expiredate = '$expiredate', "
            . "serialno = '$serialno', "
            . "datecreate = '$datecreate';";
    #echo "$sqlInsert = $sqlInsert <br>";
    $objinsert = new SQL($sqlInsert);
    $result = $objinsert->InsertData();
    #echo "$result<br>";
}

function generate_runno($j,$valvoucher) {
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
    insertSQL($instancetid, $j, $expiredate, $serialno, $datecreate, $valvoucher);
    #echo "work_id = $j, \$instancetid = $instancetid    |   " . $datecreate . " | expireddate = $expiredate | $serialno<br>";
    // echo "work_id = $j, \$id = $id    |   " . date("l jS \of F Y h:i:s A") . " <br>";date_format($expiredate, 'd/m/Y');
    // sleep(1);

//    echo"<br>list down array \$instancetid<br>";
//    print_r($instancetid);
//    echo "<br>";
    $arr_runno = array('instancetid' => $instancetid, 'datecreate' => $datecreate, 'expiredate' => $expiredate);
    return $arr_runno;
}
