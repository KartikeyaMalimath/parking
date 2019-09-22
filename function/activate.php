<?php

session_start();

include ('../include/db.php');

date_default_timezone_set('Asia/Kolkata'); 
$t=time();
$time = date("d-m-Y G:i:s", $t);

if(isset($_GET['vhactive'])){
    $vhid = $_GET['vhactive'];

    $vhstmt = "UPDATE vehicle_type_master SET active = 1, created_date = '$time' WHERE vtype_id = '$vhid'";
    mysqli_query($vhstmt);
    if($con->query($vhstmt) === TRUE) {
        echo "Activated successfully";
    }
    else {
        echo "Error activating";
    }
}

if(isset($_GET['useractive'])){
    $usrid = $_GET['useractive'];

    $usrstmt = "UPDATE user_master SET active = 1 WHERE user_id = '$usrid'";
    mysqli_query($usrstmt);
    if($con->query($usrstmt) === TRUE) {
        echo "Activated successfully";
    }
    else {
        echo "Error activating";
    }
}

if(isset($_GET['sbactive'])){
    $sbid = $_GET['sbactive'];

    $sbstmt = "UPDATE slab_master SET active = 1, created_date = '$time' WHERE slab_id = '$sbid'";
    mysqli_query($sbstmt);
    if($con->query($sbstmt) === TRUE) {
        echo "Activated successfully";
    }
    else {
        echo "Error Activating";
    }
}

?>