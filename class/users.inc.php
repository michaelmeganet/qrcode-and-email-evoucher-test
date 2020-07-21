<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author User
 */
class USER {

    protected $username;
    protected $password;
    protected $name;
    protected $credentials;
    protected $active = 'no';
    protected $google_auth_code = '0';

    function __construct() {
        
    }

    function login($username, $password) {
        $hash_password = hash('sha256', $password);

        //call using provided username
        $qr = "SELECT * FROM users WHERE username = '$username' AND password = '$hash_password'";
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultOneRowArray();
        if (!empty($result)) {
            $this->set_username($result['username']);
            $this->set_password($result['password']);
            $this->set_name($result['name']);
            $this->set_credentials($result['credentials']);
            $this->set_active($result['active']);
            $this->set_google_auth_code($result['google_auth_code']);
            return 'User Correct';
        } else {
            return 'Username or Password is incorrect';
        }
    }

    function register($name, $username, $password, $credentials, $google_auth_code, $active) {
        //make hash of password;
        $hash_password = hash('sha256', $password);
        //create array of this
        $arr_user = array('name' => $name, 'username' => $username, 'password' => $hash_password, 'credentials' => $credentials, 'google_auth_code' => $google_auth_code, 'active' => $active);
        $cnt = 0;
        $arrCount = count($arr_user);
        $qr = 'INSERT INTO users SET ';
        foreach ($arr_user as $rowKey => $rowVal) {
            $cnt++;
            $qr .= $rowKey . "=:" . $rowKey;
            if ($cnt != $arrCount) {
                $qr .= ", ";
            }
        }
        $objSQL = new SQLBINDPARAM($qr, $arr_user);
        $result = $objSQL->InsertData2();
        if ($result == 'insert ok!') {
            return 'Insert Successful';
        } else {
            return 'Insert Failed';
        }
    }

    function activate($uid, $google_auth_code, $active) {
        $arr_user = array('google_auth_code' => $google_auth_code, 'active' => $active);
        $cnt = 0;
        $arrCount = count($arr_user);
        $qr = 'UPDATE users SET ';
        foreach ($arr_user as $rowKey => $rowVal) {
            $cnt++;
            $qr .= $rowKey . "=:" . $rowKey;
            if ($cnt != $arrCount) {
                $qr .= ", ";
            }
        }
        $qr .= " WHERE uid = $uid";
        #echo "\$qr = $qr<br>";
        $objSQL = new SQLBINDPARAM($qr, $arr_user);
        $result = $objSQL->UpdateData2();
        if ($result == 'Update ok!') {
            return 'Successfully activated !';
        } else {
            return 'Failed to Activate';
        }
    }

    function deactivate($uid, $google_auth_code = 0, $active = 'no') {
        $arr_user = array('google_auth_code' => $google_auth_code, 'active' => $active);
        $cnt = 0;
        $arrCount = count($arr_user);
        $qr = 'UPDATE users SET ';
        foreach ($arr_user as $rowKey => $rowVal) {
            $cnt++;
            $qr .= $rowKey . "=:" . $rowKey;
            if ($cnt != $arrCount) {
                $qr .= ", ";
            }
        }
        $qr .= " WHERE uid = $uid";
        #echo "\$qr = $qr<br>";
        $objSQL = new SQLBINDPARAM($qr, $arr_user);
        $result = $objSQL->UpdateData2();
        if ($result == 'Update ok!') {
            return 'Successfully Deactivated !';
        } else {
            return 'Failed to Deactivate';
        }
    }

    function set_username($input) {
        $this->username = $input;
    }

    function get_username() {
        return $this->username;
    }

    function set_password($input) {
        $this->password = $input;
    }

    function get_password() {
        return $this->password;
    }

    function set_name($input) {
        $this->name = $input;
    }

    function get_name() {
        return $this->name;
    }

    function set_credentials($input) {
        $this->credentials = $input;
    }

    function get_credentials() {
        return $this->credentials;
    }

    function set_active($input) {
        $this->active = $input;
    }

    function get_active() {
        return $this->active;
    }

    function set_google_auth_code($input) {
        $this->google_auth_code = $input;
    }

    function get_google_auth_code() {
        return $this->google_auth_code;
    }

}
