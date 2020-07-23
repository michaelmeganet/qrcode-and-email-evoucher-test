<?php

namespace AUTH\User;

include 'class/dbh.inc.php';
include 'class/variables.inc.php';
include_once 'class/users.inc.php';
include_once 'auth/googleLib/GoogleAuthenticator.php';
include_once 'class/session.inc.php';

use SQL;
use USER;
use GoogleAuthenticator;
use SESSIONS;

function getLastUID() {
    $qr = 'SELECT * FROM users ORDER BY uid DESC';
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    $lastUID = $result['uid'];

    return $lastUID;
}

function getAllUser() {
    $qr = 'SELECT * FROM users ORDER BY uid DESC';
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    return $result;
}

function getAllUserCRUD() {
    $qr = 'SELECT uid, username, name, credentials, active FROM users ORDER BY uid ASC';
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultRowArray();
    return $result;
}

function getOneUser($uid) {
    $qr = "SELECT * FROM users WHERE uid = $uid ORDER BY uid DESC";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    return $result;
}

function doLogin($post_login) {
    $username = $post_login['username'];
    $password = $post_login['password'];
    $codeGoogle = $post_login['codeGoogle'];
    echo "\$username = $username,  \$password = $password, \$hash = " . hash('sha256', $password) . ",  \$codeGoogle = $codeGoogle<br>";

    $objUser0 = new USER();
    $loginResult = $objUser0->login($username, $password);
    $user_secret = $objUser0->get_google_auth_code();
    $user_credentials = $objUser0->get_credentials();
    $user_name = $objUser0->get_name();
    $user_uid = $objUser0->get_uid();

    if ($loginResult == 'User Correct') {
        echo "user is correct<br>";
        //the user is found, check if active or not
        $user_active = $objUser0->get_active();
        if ($user_active == 'yes') {
            echo "user is active<br>";
            //user is active, check google code
            echo "\$user_secret = $user_secret<br>";
            $objGA = new GoogleAuthenticator();
            $checkAuth = $objGA->verifyCode($user_secret, $codeGoogle, 2); // userAuth code, 6 digit code, 2 * 30 sec tolerance
            if ($checkAuth) {
                echo "Google auth is complete<br>";

                $objSessions = new \SESSIONS();
                $currActSession = $objSessions->getActiveSession($user_uid, $username, $codeGoogle);
                print_r($currActSession);

                if ($currActSession == 'empty') {

                    $loginMsg = 'Login Success!';
                    #$loginlogMsg = setLoginLog($username, hash('sha256', $password), $codeGoogle, $loginMsg);
                    $_SESSION['googleCode'] = $codeGoogle;
                    $_SESSION['activeUID'] = $user_uid;
                    $_SESSION['activeUser'] = $user_name;
                    $_SESSION['activeUsername'] = $username;
                    $_SESSION['activeUserCredentials'] = $user_credentials;
                    $_SESSION['startTimeout'] = time();
                    $updateActSession = $objSessions->setActiveSession($_SESSION['activeUID'], $_SESSION['activeUsername'], $_SESSION['googleCode']);

                    //if there's redirection :
                    if (isset($_SESSION['redirectLocation'])) {
                        header('Location:' . $_SESSION['redirectLocation']);
                    } else {
                        header('Location: index.php');
                    }
                } else {
                    $loginMsg = 'This account is already logged in on another place.';
                }
            } else {
                echo "Google auth is wrong<br>";
                $loginMsg = 'The 6 digit code is not valid';
            }
        } else {
            echo "user is not active<br>";
            $loginMsg = 'User is not yet activated, Contact administrator';
        }
    } else {
        echo "wrong username / password<br>";
        $loginMsg = $loginResult;
    }
    $loginlogMsg = setLoginLog($username, hash('sha256', $password), $codeGoogle, $loginMsg);
    echo "\$loginlogMsg = $loginlogMsg<br>";
    return $loginMsg;
}

function setLoginLog($username, $password, $auth_code, $remarks) {
    $qr = "INSERT INTO login_log SET "
            . "username = '$username', "
            . "password = '$password', "
            . "auth_code = '$auth_code', "
            . "remarks = '$remarks'";
    $objSQL = new SQL($qr);
    echo $qr;
    $result = $objSQL->InsertData();
    return $result;
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

