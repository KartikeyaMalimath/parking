<?php

include('include/phpqrcode/qrlib.php');
$tempDir = 'dump/';

QRcode::png('kartikeya', $tempDir.'007_1.png', QR_ECLEVEL_L, 3); 

echo '<img src="'.$tempDir.'007_1.png" />';

$date1 = date_create('28-08-2019 13:30:15');
$date2 = date_create('29-09-2019 02:30:15');
$totaldays = date_diff($date1, $date2);
$a = $totaldays->format('%a %h:%i:%s');
echo $a;

?>                                            
