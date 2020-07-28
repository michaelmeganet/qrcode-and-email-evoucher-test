<?php

namespace AUTH\User;

include_once 'class/dbh.inc.php';
include_once 'class/variables.inc.php';
include_once 'class/users.inc.php';
include_once 'auth/googleLib/GoogleAuthenticator.php';
include_once 'class/session.inc.php';

use SQL;
use Exception;
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

function doLogin2($post_login) {
    $username = $post_login['username'];
    $password = $post_login['password'];
    #echo "\$username = $username,  \$password = $password, \$hash = " . hash('sha256', $password) . "<br>";
    try {
        $objUser0 = new USER();
        $loginResult = $objUser0->login($username, $password);
        $user_uid = $objUser0->get_uid();
        if ($loginResult == 'User Correct') {
            #echo "user is correct<br>";
            //the user is found, check if active or not
            $user_active = $objUser0->get_active();
            if ($user_active == 'yes') {
                #echo "user is active<br>";
                //user is active, check session active or not 
                $objSessions = new \SESSIONS();
                #echo "user_uid = $user_uid; username = $username;<br>";
                $currActSession = $objSessions->getActiveSession($user_uid, $username, '');
                #print_r($currActSession);
                if ($currActSession == 'empty') {
                    $loginMsg = 'login ok';
                } else {
                    #echo "User is still logged in somewhere<br>";
                    //check if SESSION is timeout or not
                    $currentTime = time();
                    $lastSessionTime = $currActSession['last_active_time'];
                    #echo "currentTime = $currentTime; lastSessionTime = $lastSessionTime<br>";
                    if ($currentTime - $lastSessionTime > 1200) {
                        //session is timeout, can login.
                        //update old session first.
                    #    echo "diffTime = ".intval($currentTime-$lastSessionTime)."<br>";
                        $resultUpdSession = $objSessions->endActiveSession($user_uid, $username, $currActSession['auth_code']);
                        $loginMsg = 'login ok';
                    } else {
                        $loginMsg = 'This account is already logged in on another place.';
                        throw new Exception($loginMsg);
                    }
                }
            } else {
                #echo "user is not active<br>";
                $loginMsg = 'User is not yet activated, Contact administrator';
                throw new Exception($loginMsg);
            }
        } else {
            #echo "wrong username / password<br>";
            $loginMsg = $loginResult;
            throw new Exception($loginMsg);
        }
    } catch (Exception $exce) {
        $ErrMsg = $exce->getMessage();
        $loginlogMsg = setLoginLog($username, hash('sha256', $password), 'null', $ErrMsg);
        #echo $loginlogMsg . "<br>";
    }
    return $loginMsg;
}

function doGoogleAuthCheck($post_auth) {
    $username = $post_auth['username'];
    $password = $post_auth['password'];
    $codeGoogle = $post_auth['codeGoogle'];
    #echo "\$username = $username,  \$password = $password, \$hash = " . hash('sha256', $password) . "<br>";
    try {
        $objUser = new USER();
        $loginResult = $objUser->login($username, $password);
        $user_uid = $objUser->get_uid();
        $user_name = $objUser->get_name();
        $user_credentials = $objUser->get_credentials();
        $user_secret = $objUser->get_google_auth_code();
        if ($loginResult == 'User Correct') {
            $objGA = new GoogleAuthenticator();
            $checkAuth = $objGA->verifyCode($user_secret, $codeGoogle);
            if ($checkAuth) {
                #echo "Google auth is OK<br>";
                $authMsg = 'Login Success!';
                #$loginlogMsg = setLoginLog($username, hash('sha256', $password), $codeGoogle, $loginMsg);
                $_SESSION['googleCode'] = $codeGoogle;
                $_SESSION['activeUID'] = $user_uid;
                $_SESSION['activeUser'] = $user_name;
                $_SESSION['activeUsername'] = $username;
                $_SESSION['activeUserCredentials'] = $user_credentials;
                $_SESSION['startTimeout'] = time();
                $objSessions = new \SESSIONS();
                $updateActSession = $objSessions->setActiveSession($_SESSION['activeUID'], $_SESSION['activeUsername'], $_SESSION['googleCode'], $_SESSION['startTimeout']);

                //if there's redirection :
                if (isset($_SESSION['redirectLocation'])) {
                    header('Location:' . $_SESSION['redirectLocation']);
                } else {
                    header('Location: index.php');
                }
            } else {
                #echo "Google Auth is incorrect<br>";
                $authMsg = 'The 6 Digit Code is incorrect';
                throw new Exception($authMsg);
            }
        } else {
            #echo "User check error<br>";
            $authMsg = 'error';
            throw new Exception($authMsg);
        }
    } catch (Exception $ex) {
        $errMsg = $ex->getMessage();
        $loginlogMsg = setLoginLog($username, hash('sha256', $password), $codeGoogle, $errMsg);
        #echo "\$loginlogMsg = $loginlogMsg<br>";
    }

    $loginlogMsg = setLoginLog($username, hash('sha256', $password), $codeGoogle, $authMsg);
    return $authMsg;
}

/*
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
 * 
 */

function setLoginLog($username, $password, $auth_code, $remarks) {
    $qr = "INSERT INTO login_log SET "
            . "username = '$username', "
            . "password = '$password', "
            . "auth_code = '$auth_code', "
            . "remarks = '$remarks'";
    $objSQL = new SQL($qr);
    #echo $qr;
    $result = $objSQL->InsertData();
    return $result;
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

