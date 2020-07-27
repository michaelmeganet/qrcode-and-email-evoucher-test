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

    function setActiveSession($uid, $username, $googleCode) {
        $qr = "INSERT INTO active_session SET "
                . "uid = $uid, "
                . "username = '$username', "
                . "auth_code = '$googleCode', "
                . "current_active = 'yes'";
        $objSQL = new SQL($qr);
        $result = $objSQL->InsertData();
        
        if ($result == 'insert ok!'){
            return 'Insert Successful';
        }else{
            return 'Insert Failed';
        }
    }

    function getActiveSession($uid, $username, $googleCode) {
        $qr = "SELECT * FROM active_session WHERE uid = $uid AND current_active = 'yes' ";
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

}
