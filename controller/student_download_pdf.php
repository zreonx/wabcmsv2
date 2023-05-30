<?php
// Set up variables
$clearance_id = $_GET['clearance_id'];
$url = '../student/';
$pdf_name = 'clerance.pdf';

// Generate the PDF file using wkhtmltopdf command
$command = 'wkhtmltopdf "'.$url.'" "'.$pdf_name.'"';
exec($command);

// Download the generated PDF file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($pdf_name));
header('Content-Length: ' . filesize($pdf_name));
readfile($pdf_name);

// Delete the generated PDF file from server
unlink($pdf_name);
?>