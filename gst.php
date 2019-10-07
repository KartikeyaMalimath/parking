<?php

include('include/db.php');

$com = 'fm5d7534212edbd';
$totalamount = '20';
$helmetcharge = '0';
$heladv= '0';
$stmt = "SELECT cgst, sgst FROM company_master WHERE company_id = '$com'";
$res = $con->query($stmt);
$row = $res->fetch_assoc();

$cgst = ($totalamount + $helmetcharge + $heladv) - (($totalamount + $helmetcharge + $heladv) * (100 / (100 + $row['cgst'])));
$sgst = ($totalamount + $helmetcharge + $heladv) - (($totalamount + $helmetcharge + $heladv) * (100 / (100 + $row['sgst'])));
$gst = $cgst + $sgst;
echo round($cgst,3)." ".round($sgst,3)." ".round($gst,5);
?>