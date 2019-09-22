<?php

session_start();

include ('../include/db.php');

date_default_timezone_set('Asia/Kolkata'); 
$t=time();
$time = date("d-m-Y G:i:s", $t);


if(isset($_GET['vhinactive'])){
    $vhid = $_GET['vhinactive'];

    $vhstmt = "UPDATE vehicle_type_master SET active = 0, created_date = '$time' WHERE vtype_id = '$vhid'";
    mysqli_query($vhstmt);
    if($con->query($vhstmt) === TRUE) {
        echo "Deactivated successfully";
    }
    else {
        echo "Error deactivating";
    }
}

if(isset($_GET['userinactive'])){
    $usrid = $_GET['userinactive'];

    $usrstmt = "UPDATE user_master SET active = 0 WHERE user_id = '$usrid'";
    mysqli_query($usrstmt);
    if($con->query($usrstmt) === TRUE) {
        echo "Deactivated successfully";
    }
    else {
        echo "Error deactivating";
    }
}

if(isset($_GET['sbinactive'])){
    $sbid = $_GET['sbinactive'];

    $sbstmt = "UPDATE slab_master SET active = 0, created_date = '$time' WHERE slab_id = '$sbid'";
    mysqli_query($sbstmt);
    if($con->query($sbstmt) === TRUE) {
        echo "Deactivated successfully";
    }
    else {
        echo "Error deactivating";
    }
}

?>