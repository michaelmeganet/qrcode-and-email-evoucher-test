<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of session
 *
 * @author User
 */
class SESSIONS {

    //put your code here
    protected $asid;
    protected $uid;
    protected $username;
    protected $auth_code;
    protected $current_active;
    protected $last_active_time;

    function setActiveSession($uid, $username, $googleCode,$last_active_time) {
        $qr = "INSERT INTO active_session SET "
                . "uid = $uid, "
                . "username = '$username', "
                . "auth_code = '$googleCode', "
                . "current_active = 'yes', "
                . "last_active_time = $last_active_time";
        $objSQL = new SQL($qr);
        $result = $objSQL->InsertData();
        
        if ($result == 'insert ok!'){
            return 'Insert Successful';
        }else{
            return 'Insert Failed';
        }
    }

    function getActiveSession($uid, $username, $googleCode) {
        $qr = "SELECT * FROM active_session WHERE uid = $uid AND current_active = 'yes' ORDER BY asid DESC ";
        #echo "\$qr = $qr<br>";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        
        if(!empty($result)){
            return $result;
        }else{
            return 'empty';
        }
    }
    
    function endActiveSession($uid,$username,$googleCode){
        $qr = "UPDATE active_session SET current_active = 'no' WHERE uid = $uid AND auth_code = $googleCode";
        $objSQL = new SQL($qr);
        $result = $objSQL->getUpdate();
        if ($result == 'updated'){
            return 'Session Ended';
        }else{
            return 'Failed to end Session';
        }
    }
    
    function updateActiveTime($uid,$username,$googleCode,$last_active_time){
        $qr = "UPDATE active_session SET last_active_time = $last_active_time WHERE uid = $uid AND auth_code = $googleCode;";
        $objSQL = new SQL($qr);
        $result = $objSQL->getUpdate();
        if($result == 'updated'){
            return 'Updated Time';
        }else{
            return 'Failed to Update Time';
        }
    }

}
