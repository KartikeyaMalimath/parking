<?php

include ("../include/db.php");

session_start();

$UID = $_SESSION['userID'];

if(isset($_GET['id'])){
    $CID = $_GET['id'];

    //capture current time for checkout
    date_default_timezone_set('Asia/Kolkata'); 
    $t=time();
    $time = date("d-m-Y G:i:s", $t);

    //prepare outdate for calculation
    $outdate = date_create($time);

    //fetch customer transaction details
    $gettrn = "SELECT * FROM transaction_master WHERE trn_id = '$CID'";
    $trnres = $con->query($gettrn);
    $trnrow = $trnres->fetch_assoc();

    //In time retrival
    $intimefetch = $trnrow['check_in'];
    $intimedate = strtotime($intimefetch);

    //prepare indate for calculation
    $outdate = date_create($intimedate);

    //duration calculation
    $date1 = date_create($indate);
    $date2 = date_create($outdate);
    $totaldays = date_diff($date1, $date2);
    $days = $totaldays->format('%a');
    $hrs = $totaldays->format('%h');
    $mins = $totaldays->format('%i');

    //total duration
    $totaldur = $days*1440 + $hrs * 60 + $mins;
    //5 min grace period
    if($totaldur > 5) {
        $totaldur = $totaldur - 5;
    }




} else {
    echo "<script>top.window.location = '../public/scan.php'</script>";
}


?>