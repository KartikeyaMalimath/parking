<?php

include('include/phpqrcode/qrlib.php');
$tempDir = 'dump/';

QRcode::png('kartikeya', $tempDir.'007_1.png', QR_ECLEVEL_L, 3); 

echo '<img src="'.$tempDir.'007_1.png" />';

?>                                              
