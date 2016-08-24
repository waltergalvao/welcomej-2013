<?php
header("Content-Type: application/octet-stream");

$file = "3licoes.pdf";
header("Content-Disposition: attachment; filename=" . urlencode($file));   
header("Content-Type: application/pdf");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Description: File Transfer");            
header("Content-Length: " . filesize('/ej/app/webroot/'.$file));
flush(); // this doesn't really matter.
$fp = fopen($file, "r");
while (!feof($fp))
{
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
} 
fclose($fp);
?>