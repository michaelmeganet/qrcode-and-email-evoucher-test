<?php
require 'vendor/autoload.php'; //required, this is to autoload composer.
use Dompdf\Dompdf;


// instantiate and use the dompdf class
// https://github.com/dompdf/dompdf#quick-start
$dompdf = new Dompdf();
    ob_start();  //reference for using output buffer : https://stackoverflow.com/questions/50695307/render-html-with-dynamic-variable-values-with-dompdf
    include "evoucher-generate.php";
    #include "letterhtml.html";
    #require('./formReport.php');
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $html = ob_get_contents();
    ob_get_clean();
    #$html = file_get_contents("./formReport.php");
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    #$dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

//Save PDF into file
    $output = $dompdf->output();
    file_put_contents('./resource/pdf/evoucher_tmp.pdf', $output);
// Output the generated PDF to Browser
 #   $dompdf->stream("download1",array('Attachment' => 0));

?>
