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

class VOUCHER {

    protected $instanceid;
    protected $userid;
    protected $valvoucher;
    protected $datecreate;
    protected $expiredate;
    protected $table;

    public function __construct($userid, $valvoucher, $datecreate, $table) {

        $this->table = $table;

        $this->set_userid($userid);
        $this->set_valvoucher($valvoucher);
        $this->set_datecreate($datecreate);
        //expiration date is 2 Months from now
        $expiredate = date_format(date_add(date_create($datecreate), date_interval_create_from_date_string("+2 Months")), "Y-m-d");
        $this->set_expiredate($expiredate);

        $instanceid = $this->generate_instanceid();
        $this->set_instanceid($instanceid);

        //check if instanceid is exclusive or not
        $checkInsID = $this->check_instanceid();
        while ($checkInsID != 'instanceid valid') {
            $instanceid = $this->generate_instanceid();
            $this->set_instanceid($instanceid);
            $checkInsID = $this->check_instanceid();
        }
    }

    public function generate_instanceid() { //$j = $userid
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

    public function check_instanceid() {
        $table = $this->table;
        $instanceid = $this->get_instanceid();
        $qr = "SELECT * FROM $table WHERE instanceid = $instanceid";
        $objCK = new SQL($qr);
        $result = $objCK->getResultOneRowArray();
        if (empty($result)) {
            $info = 'instanceid valid';
        } else {
            $info = 'instanceid not valid';
        }
        return $info;
    }

    public function set_instanceid($input) {
        $this->instanceid = $input;
    }

    public function get_instanceid() {
        return $this->instanceid;
    }

    public function set_userid($input) {
        $this->userid = $input;
    }

    public function get_userid() {
        return $this->userid;
    }

    public function set_valvoucher($input) {
        $this->valvoucher = $input;
    }

    public function get_valvoucher() {
        return $this->valvoucher;
    }

    public function set_datecreate($input) {
        $this->datecreate = $input;
    }

    public function get_datecreate() {
        return $this->datecreate;
    }

    public function set_expiredate($input) {
        $this->expiredate = $input;
    }

    public function get_expiredate() {
        return $this->expiredate;
    }

}

Class E_VOUCHER extends VOUCHER {

    protected $serialno;
    protected $void = 'no'; //default value = no
    protected $table = 'evoucher_serial';

    public function __construct($userid, $valvoucher) {
        $table = $this->table;
        $datecreate = date('Y-m-d H:i:s');
        parent::__construct($userid, $valvoucher, $datecreate, $table);
        $lastSerialNo = $this->fetchLastSerialNo();
        #echo "\$lastSerialNo = $lastSerialNo<br>";
        $serialno = $lastSerialNo + 1;
        #echo "\$serialno = $serialno<br>";
        $this->set_serialno($serialno);
    }

    public function create_voucher() {
        $result = $this->insertSQL();
        return $result;

        /* // The function for E-Voucher doesn't need check for void or expiration
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
          $result = "Runningno already active, please check ($inf_checkExpiryDate | $inf_checkVoid)";
          }
          }
          return $result;
         *
         */
    }

    protected function insertSQL() {
        //columns : instanceid, userid, valvoucher, expiredate, serialno, datecreate, dateredeem, void;
        $table = $this->get_table();
        $instanceid = $this->get_instanceid();
        $userid = $this->get_userid();
        $valvoucher = $this->get_valvoucher();
        $expiredate = $this->get_expiredate();
        $serialno = $this->get_serialno();
        $datecreate = $this->get_datecreate();
        //create post array
        $bindparamArray = array(
            'instanceid' => $instanceid,
            'userid' => $userid,
            'valvoucher' => $valvoucher,
            'expiredate' => $expiredate,
            'serialno' => $serialno,
            'datecreate' => $datecreate
        );

        $qr = "INSERT INTO $table SET "
                . "instanceid=:instanceid, "
                . "userid=:userid, "
                . "valvoucher=:valvoucher, "
                . "expiredate=:expiredate, "
                . "serialno=:serialno, "
                . "datecreate=:datecreate ";
        $objSQL = new SQLBINDPARAM($qr, $bindparamArray);
        $result = $objSQL->InsertData2();
        if ($result == 'insert ok!') {
            $info = 'Insert Successful!';
        } else {
            $info = 'Insert Failed';
        }
        return $info;
    }

    public function fetchLastSerialNo() {
        $table = $this->get_table();
        $qr = "SELECT * FROM $table ORDER BY serialno DESC";

        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if (!empty($result)) {
            $lastSerialNo = $result['serialno'];
        } else {
            $lastSerialNo = 0;
        }
        return $lastSerialNo;
    }

      public function checkExpiryDate($instanceid){
      $table = $this->get_table();
      $currDate = date_format(date_create($this->get_datecreate()),'Y-m-d');
      #echo "\$currDate = $currDate<br>";
      $runningno = $this->get_runningno();
      $qr = "SELECT * FROM $table WHERE instanceid = $instanceid ORDER BY serialno DESC;";
      $objSQL = new SQL($qr);
      $result = $objSQL->getResultOneRowArray();
      if ($currDate >= $result['expiredate']){
      #echo "Voucher has expired <br>";
      $info = 'voucher expired';

      }else{
      #echo "Voucher still active<br>";
      $info = 'voucher not expired';
      }
      return $info;
      }

      public function checkVoid($instanceid){
      $table = $this->get_table();
      $runningno = $this->get_runningno();
      $qr = "SELECT * FROM $table WHERE instanceid = $instanceid ORDER BY serialno DESC";
      $objSQL = new SQL($qr);
      $result = $objSQL->getResultOneRowArray();
      if($result['void'] == 'no'){
      #echo "Voucher not void<br>";
      $info = 'voucher not void';
      }else{
      #echo "Voucher void<br>";
      $info = 'voucher void';
      }
      return $info;
      }

    public function get_serialno() {
        return $this->serialno;
    }

    public function set_serialno($input) {
        $this->serialno = $input;
    }

    public function get_void() {
        return $this->void;
    }

    public function set_void($input) {
        $this->void = $input;
    }

    public function get_table() {
        return $this->table;
    }

    public function set_table($input) {
        $this->table = $input;
    }

}

Class PREPRINT_VOUCHER extends VOUCHER {

    protected $runningno;
    protected $serialno;
    protected $void = 'no'; //default value = no
    protected $table = 'preprint_serial';

    public function __construct($userid, $valvoucher, $runningno) {
        $table = $this->table;
        $datecreate = date('Y-m-d H:i:s');
        parent::__construct($userid, $valvoucher, $datecreate, $table);
        $this->set_runningno($runningno);
        $lastSerialNo = $this->fetchLastSerialNo(); ///serialno format = int
        #echo "\$lastSerialNo = $lastSerialNo<br>";
        $serialno = $lastSerialNo + 1; //initialize serialno;
        #echo "\$serialno = $serialno<br>";
        $this->set_serialno($serialno);
    }

    public function create_voucher() {
        $runningno = $this->get_runningno();
        //check if the runningno available or not
        $inf_checkRunningNo = $this->checkRunningNo($runningno);
        if ($inf_checkRunningNo == 'runno avail') {
            //runningno available, can create new voucher
            $result = $this->insertSQL();
        } else {
            //runningno not available, check if voucher valid or not
            $inf_checkExpiryDate = $this->checkExpiryDate($runningno);
            $inf_checkVoid = $this->checkVoid($runningno);
            if (($inf_checkExpiryDate == 'voucher expired') || ($inf_checkVoid == 'voucher void')) {
                //voucher is not valid, can create new voucher
                $result = $this->insertSQL();
            } else {
                //voucher is still valid, runningno cannot be used,
                $result = "Runningno already active, please check ($inf_checkExpiryDate | $inf_checkVoid)";
            }
        }
        return $result;
    }

    protected function insertSQL() {
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
            'runningno' => $runningno,
            'instanceid' => $instanceid,
            'userid' => $userid,
            'valvoucher' => $valvoucher,
            'expiredate' => $expiredate,
            'serialno' => $serialno,
            'datecreate' => $datecreate
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
        if ($result == 'insert ok!') {
            $info = 'Insert Successful!';
        } else {
            $info = 'Insert Failed';
        }
        return $info;
    }

    public function fetchLastSerialNo() {
        $table = $this->get_table();
        $qr = "SELECT * FROM $table ORDER BY serialno DESC";

        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if (!empty($result)) {
            $lastSerialNo = $result['serialno'];
        } else {
            $lastSerialNo = 0;
        }
        return $lastSerialNo;
    }

    public function checkRunningNo($runningno) {
        $table = $this->get_table();
        #$runningno = $this->get_runningno();
        $qr = "SELECT * FROM $table WHERE runningno = $runningno ORDER BY serialno DESC;";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();

        if (empty($result)) {
            echo "Running no has not been used<br>";
            $info = 'runno avail';
        } else {
            echo "Running no has been used<br>";
            $info = 'runno not avail';
        }
        return $info;
    }

    public function checkExpiryDate($runningno) {
        $table = $this->get_table();
        $currDate = date_format(date_create($this->get_datecreate()), 'Y-m-d');
        #echo "\$currDate = $currDate<br>";
        #$runningno = $this->get_runningno();
        $qr = "SELECT * FROM $table WHERE runningno = $runningno ORDER BY serialno DESC;";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if ($currDate >= $result['expiredate']) {
            #echo "Voucher has expired <br>";
            $info = 'voucher expired';
        } else {
            #echo "Voucher still active<br>";
            $info = 'voucher not expired';
        }
        return $info;
    }

    public function checkVoid($runningno) {
        $table = $this->get_table();
        #$runningno = $this->get_runningno();
        $qr = "SELECT * FROM $table WHERE runningno = $runningno ORDER BY serialno DESC";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if ($result['void'] == 'no') {
            #echo "Voucher not void<br>";
            $info = 'voucher not void';
        } else {
            #echo "Voucher void<br>";
            $info = 'voucher void';
        }
        return $info;
    }

    public function get_runningno() {
        return $this->runningno;
    }

    public function set_runningno($input) {
        $this->runningno = $input;
    }

    public function get_serialno() {
        return $this->serialno;
    }

    public function set_serialno($input) {
        $this->serialno = $input;
    }

    public function get_void() {
        return $this->void;
    }

    public function set_void($input) {
        $this->void = $input;
    }

    public function get_table() {
        return $this->table;
    }

    public function set_table($input) {
        $this->table = $input;
    }

}
