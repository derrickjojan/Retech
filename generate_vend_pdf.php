<?php
// Include the mPDF library
require 'pdf/vendor/autoload.php';

// Create an mPDF object
$mpdf = new \Mpdf\Mpdf();

// Capture the output of viewsales.php into a variable
ob_start();
include 'viewvend.php';
$html = ob_get_clean();

// Write HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF as a download
$mpdf->Output('viewvend.pdf', \Mpdf\Output\Destination::DOWNLOAD);
