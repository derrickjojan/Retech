<?php
// Include the mPDF library
require 'pdf/vendor/autoload.php';

// Create an mPDF object
$mpdf = new \Mpdf\Mpdf();

// Capture the output of viewsales.php into a variable
ob_start();
include 'viewsubcat.php';
$html = ob_get_clean();

// Write HTML content to the PDF
$mpdf->WriteHTML($html);

$mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10pt; border-top: 1px solid #000000;">Page {PAGENO} of {nb}</div>');
// Output the PDF as a download
$mpdf->Output('viewsubcat.pdf', \Mpdf\Output\Destination::DOWNLOAD);
