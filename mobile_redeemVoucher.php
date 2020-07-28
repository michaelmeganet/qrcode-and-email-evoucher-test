<?php

namespace voucher\Validate;

session_start();
include_once "include/session.php";
include_once 'new-header.php';

if (isset($_SESSION['VOUCHER_UPD_MSG'])) {
    $voucherUpdMsg = $_SESSION['VOUCHER_UPD_MSG'];
    unset($_SESSION['VOUCHER_UPD_MSG']);
}
?>
<div class='container text-center'>
    <?php
    if (isset($voucherUpdMsg)) {
                ?>
                <div class="form-group row row-no-gutters col-sm-5 ">
                    <?php
                    $chkMsg = stripos($voucherUpdMsg, 'congratulation');
                    #echo "\$chkMsg = $chkMsg<br>". var_dump($chkMsg)."<br>";
                    if (($chkMsg)) {
                        #echo "exist<br>";
                        echo "<div class='alert alert-success' style='font-size:12px'>";
                    } else {
                        #echo "not eist<br>";
                        echo "<div class='alert alert-danger'>";
                    }
                    ?>
                    
                    <?php echo $voucherUpdMsg."<br><br>"
                            . "Please close this window.";
                    
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
</div>