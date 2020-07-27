<?php

namespace voucher\Log;

require 'voucherlog/voucherlog-functions.php';
//set pageURL
$pageurl = 'voucherlog.php?log=PP';
//set to first page if no page selected
$page = isset($_GET['page']) ? $_GET['page'] : 1;
//set number of rows per page
$rowPage = 20;
//calculate for limit clause
$startLimit = ($rowPage * $page) - $rowPage;
//read Voucher List from evoucher_serial table
$ppvoucher_list = getPPVoucherListFilter('none', 'none', $startLimit, $rowPage);
//get number of records in the table
$rowCounter = countPPVoucherListFilter('none', '');

if (isset($_POST['submitFilter'])) {
    $_SESSION['filterby'] = $_POST['filterby'];
    $_SESSION['filterval'] = $_POST['filterval'];
}

if (isset($_POST['resetFilter']) || isset($_GET['init'])) {
    unset($_SESSION['filterby']);
    unset($_SESSION['filterval']);
}
if (isset($_SESSION['filterby']) && $_SESSION['filterval']) {
    $ppvoucher_list = getPPVoucherListFilter($_SESSION['filterby'], $_SESSION['filterval'], $startLimit, $rowPage);
    $rowCounter = countPPVoucherListFilter($_SESSION['filterby'], $_SESSION['filterval']);
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
    <h3><b>Pre-Printed Voucher Log</b></h3>
    <br>
    <br>
    <div class="form-group col col-4">
        <form name='filterform' id='filterform' action='voucherlog.php?log=PP' method="POST">
            <label class="label label-warning" style="font-size:12px">Filter :</label>
            <input class="form-actions" type="text" value="" placeholder="filter" name="filterval" id="filterval" />
            <label><input type="radio" name="filterby" id='filterby' value="user" checked/>By Issuer</label>
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
        <a href='voucherlog.php?log=log&data=PP' class=" btn btn-default pull-right">Export Log Files</a>
    </form>
    <?php
    include 'voucherlog/pagination.php';
    echo "<label class='label label-warning' style='font-size:11px'>Viewing $firstRecord - $lastRecord of $rowCounter records.</label>"
    ?>
    <table class="table table-responsive table-bordered" style="overflow-y: auto;max-height: 400px;text-align: center">
        <thead style="background-color: grey;color:white">
            <tr>
                <th>ID</th>
                <th>Preprinted Serial</th>
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
            foreach ($ppvoucher_list as $evoucher_data) {
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