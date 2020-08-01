<?php

namespace voucher\Log;

require 'voucherlog/voucherlog-functions.php';
//set pageURL
$pageurl = 'voucherlog.php?log=EV';
//set to first page if no page selected
$page = isset($_GET['page']) ? $_GET['page'] : 1;
//set number of rows per page
$rowPage = 20;
//calculate for limit clause
$startLimit = ($rowPage * $page) - $rowPage;
//read Voucher List from evoucher_serial table
$evoucher_list = getEVoucherListFilter('none', 'none', $startLimit, $rowPage);
//get number of records in the table
$rowCounter = countEVoucherListFilter('none', '');

if (isset($_POST['submitFilter'])) {
    $_SESSION['filterby'] = $_POST['filterby'];
    $_SESSION['filterval'] = $_POST['filterval'];
}

if (isset($_POST['resetFilter']) || isset($_GET['init'])) {
    unset($_SESSION['filterby']);
    unset($_SESSION['filterval']);
}
if (isset($_SESSION['filterby']) && $_SESSION['filterval']) {
    $evoucher_list = getEVoucherListFilter($_SESSION['filterby'], $_SESSION['filterval'], $startLimit, $rowPage);
    $rowCounter = countEVoucherListFilter($_SESSION['filterby'], $_SESSION['filterval']);
    switch ($_SESSION['filterby']) {
        case 'cusname':
            $filterby = 'Customer Name';
            break;
        case 'user':
            $filterby = 'Issuer';
            break;
    }
    $filterval = $_SESSION['filterval'];
}
#echo "row Count = $rowCounter<br>";
?>

<div class="container">
    <form action="index.php" method="post">
        <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
    </form>
    <h3><b>E-Voucher Log</b></h3>
    <br>
    <br>
    <div class="form-group col col-4">
        <form name='filterform' id='filterform' action='voucherlog.php?log=EV' method="POST">
            <label class="label label-warning" style="font-size:12px">Filter :</label>
            <input class="form-actions" type="text" value="" placeholder="filter" name="filterval" id="filterval" />
            <label><input type="radio" name="filterby" id='filterby' value="cusname" checked="checked"/>By Customer</label>
            <label><input type="radio" name="filterby" id='filterby' value="user" />By Issuer</label>
            <input type='submit' value='GO' class='btn btn-primary' name='submitFilter' id='submitFilter' />
            <input type='submit' value='Reset Filter' class='btn btn-warning' name='resetFilter' id='resetFilter' />
        </form>
    </div>
    <?php
    if (isset($_SESSION['filterval'])) {
        if ($_SESSION['filterval'] != '') {
            ?>
            <div class='form-group col col-4'>
                <label class='label-info label' style='font-size:12px'>Filter using [<?php echo $filterval . "] on " . $filterby; ?></label>
            </div>
            <?php
        }
    }
    ?>
    <form action="" method="post">
        <a href='voucherlog.php?log=log&data=EV' class=" btn btn-default pull-right">Export Log Files</a>
    </form>
    <?php
    include 'voucherlog/pagination.php';
    ?>
    <table class="table table-responsive table-bordered" style="overflow-y: auto;max-height: 400px;text-align: center">
        <thead style="background-color: grey;color:white">
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>voucher no</th>
                <th>Value</th>
                <th>Issue Date</th>
                <th>Expire Date</th>
                <th>Redeem Date</th>
                <th>Void</th>
                <th>Issuer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($evoucher_list as $evoucher_data) {
                echo "<tr>";
                foreach ($evoucher_data as $key => $val) {
                    echo "<td>$val</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>