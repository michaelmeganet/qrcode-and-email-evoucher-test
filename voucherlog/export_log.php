<?php

namespace voucher\Log;

require 'voucherlog/voucherlog-functions.php';
if (isset($_GET['data'])) {
    $log = $_GET['data'];
    switch ($log) {
        case 'EV':
            $tablename = 'EVoucherLog';
            $previousURL = 'voucherlog.php?log=EV&init=yes';
            if (isset($_SESSION['filterby']) && isset($_SESSION['filterval'])) {
                $data_list = getEVoucherListFilter($_SESSION['filterby'], $_SESSION['filterval']);
            } else {
                $data_list = getEVoucherListFilter();
            }
            break;
        case 'PP':
            $tablename = 'PreprintVoucherLog';
            $previousURL = 'voucherlog.php?log=PP&init=yes';
            if (isset($_SESSION['filterby']) && isset($_SESSION['filterval'])) {
                $data_list = getPPVoucherListFilter($_SESSION['filterby'], $_SESSION['filterval']);
            } else {
                $data_list = getPPVoucherListFilter();
            }
            break;
    }
} else {
    die("Can't go this way, <a href='index.php'>Click here to return</a>");
}
?>

<div class="container">
    <div class="content-main">
        <form action="<?php echo $previousURL; ?>" method="post">
            <input class=" btn btn-warning pull-right" type = "submit" name="reset_click" id="reset_click" value = "Go Back">
        </form>
        <label>Export As :</label>
        <table class="table table-responsive table-bordered" style="overflow-y: auto;max-height: 400px;text-align: center" id='<?php echo $tablename; ?>' name='<?php echo $tablename; ?>'>
            <thead style="background-color: grey;color:white">
                <?php
                foreach ($data_list as $datarow) {
                    echo "<tr>";
                    foreach ($datarow as $key => $val) {
                        echo "<th>$key</th>";
                    }
                    echo "</tr>";
                    break;
                }
                ?>
            </thead>
            <tbody>
                <?php
                foreach ($data_list as $datarow) {
                    echo "<tr>";
                    foreach ($datarow as $key => $val) {
                        if (stripos($key, 'date')) {
                            
                            echo "<td class='tableexport-date-target'>$val</td>";
                        } else {
                            echo "<td>$val</td>";
                        }
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <script type="text/javascript" src="./assets/html-excel/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="./assets/html-excel/bower_components/js-xlsx/dist/xlsx.core.min.js"></script>
        <script type="text/javascript" src="./assets/html-excel/bower_components/blobjs/Blob.min.js"></script>
        <script type="text/javascript" src="./assets/html-excel/bower_components/file-saverjs/FileSaver.min.js"></script>
        <script type="text/javascript" src="./assets/html-excel/dist/js/tableexport.min.js"></script>
        <script>

            // Default sheetname if `sheetname: false|null|undefined|""`
            //TableExport.prototype.defaultSheetname = 'fallback-name';
            // **** jQuery **************************
            // $.fn.tableExport.defaultSheetname = 'fallback-name';
            // **************************************

            var testTable = document.getElementById('<?php echo $tablename; ?>');
            new TableExport(testTable, {
                sheetname: 'worksheet',
                position: 'top',
                formats: ['xlsx', 'csv']

            });
            // **** jQuery **************************
            //    $(SheetnameTable1).tableExport({
            //        sheetname: 'super-worksheet'
            //    });
            // **************************************
            /**     
             var XLS = instance.CONSTANTS.FORMAT.XLS;
             var CSV = instance.CONSTANTS.FORMAT.CSV;
             var TXT = instance.CONSTANTS.FORMAT.TXT;
             
             //                                          // "id"  // format
             var buttonXLS = instance.getExportData()[tableId][XLS];
             var buttonCSV = instance.getExportData()[tableId][CSV];
             var buttonTXT = instance.getExportData()[tableId][CSV];
             
             // get filesize
             var bytesXLS = instance.getFileSize(buttonXLS.data, buttonXLS.fileExtension);
             var bytesCSV = instance.getFileSize(buttonCSV.data, buttonCSV.fileExtension);
             var bytesTXT = instance.getFileSize(buttonTXT.data, buttonTXT.fileExtension);
             
             console.log('filesize (XLS):', bytesXLS + 'B');
             console.log('filesize (CSV):', bytesCSV + 'B');
             console.log('filesize (TXT):', bytesTXT + 'B');
             
             var XLSbutton = document.getElementById('customXLSButton');
             XLSbutton.addEventListener('click', function (e) {
             //                   // data             // mime                 // name                 // extension
             instance.export2file(buttonXLS.data, buttonXLS.mimeType, buttonXLS.filename, buttonXLS.fileExtension);
             });
             
             var CSVbutton = document.getElementById('customCSVButton');
             CSVbutton.addEventListener('click', function (e) {
             //                   // data             // mime                 // name                 // extension
             instance.export2file(buttonCSV.data, buttonCSV.mimeType, buttonCSV.filename, buttonCSV.fileExtension);
             });
             
             var TXTbutton = document.getElementById('customTXTButton');
             TXTbutton.addEventListener('click', function (e) {
             
             instance.export2file(buttonTXT.data, buttonTXT.mimeType, buttonTXT.filename, buttonTXT.fileExtension);
             });
             */
        </script>
    </div>
</div>