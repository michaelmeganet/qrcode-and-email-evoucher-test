<?php

session_start();
include "include/session.php";
// include 'auth/AUTH-header.php';
include_once '../qrcode-and-email-evoucher-test/new-header.php';
if (isset($_GET['Aview'])) {
    $Aview = $_GET['Aview'];
} else {
    $Aview = 'main';
}

switch ($Aview) {
    case 'main':
        $title = 'User CRUD';
        include_once 'auth/AUTH-main.php';
        break;

    case 'RG':
        $title = 'User Register';
        include_once 'auth/user-register.php';

        break;
    case 'AA':
        $title = 'Activate Authenticator';
        include_once 'auth/activateAuthenticator.php';
        break;
    case 'RU':
        $title = 'User Details';
        include_once 'auth/AUTH-DetailsUser.php';
        break;
    case 'UU':
        $title = 'Edit User';
        include_once 'auth/AUTH-UpdateUser.php';
        break;

    case 'DU':
        $title = 'Delete User';
        include_once 'auth/AUTH-DeleteUser.php';
    default:
        include_once 'auth/AUTH-main.php';
        break;
}
?>

<?php ?>