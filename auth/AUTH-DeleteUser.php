<?php
namespace AUTH\User\Delete;
require 'AUTH-functions.php';
use USER;

if (isset($_GET['uid'])){
    $uid = $_GET['uid'];
    $post_data = \AUTH\User\getOneUser($uid);
    $objUser = new USER();
    $deleteResult = $objUser->delete($uid);
    $_SESSION['delMsg'] = $deleteResult;
    echo '<META HTTP-EQUIV="refresh" content="0;URL=AUTH-index.php?Aview=main">'; //using META tags instead of headers because headers didn't work in PHP5.3
}else{
    die('Cannot reach the page this way, <a href="AUTH-index.php?Aview=main">Please Try Again</a>.');
}

?>
