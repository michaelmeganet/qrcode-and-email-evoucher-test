<?php
session_start();
include 'auth/AUTH-header.php';
if (isset($_GET['Aview'])){
    $Aview = $_GET['Aview'];
}else{
    $Aview = 'RG';
}

switch ($Aview) {
    case 'RG':
        $title = 'User Register';
        include_once 'auth/user-register.php';

        break;
    case 'AA':
        $title = 'Activate Authenticator';
        include_once 'auth/activateAuthenticator.php';

    default:
        break;
}
?>

<?php

?>