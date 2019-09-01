<?php

date_default_timezone_set('Asia/Kolkata'); 
    $t=time();
    $time = date("d-m-Y G:i:s", $t);

    $indate = date("30-08-2019 22:30:00");
    $outdate = date("01-09-2019 21:00:00");

    $date1 = date_create($indate);
    $date2 = date_create($outdate);
    $totaldays = date_diff($date1, $date2);
    $days = $totaldays->format('%a');
    $hrs = $totaldays->format('%h');
    $mins = $totaldays->format('%i');
    echo $days." days ".$hrs." hrs ".$mins." mins";

?>

