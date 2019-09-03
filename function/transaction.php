<?php 

session_start();
include ("../include/db.php");

$UID = $_SESSION['userID'];

$time = $_POST['time'];
$ttldurtoupdt = $_POST['ttldur'];
$totalamount = $_POST['amount'];
$helmetcharge = $_POST['helcharge'];
$CID = $_POST['cid'];
$slabId = $_POST['slabid'];
$slabName = $_POST['slabnm'];


$trnupdatestmt = "UPDATE transaction_master SET check_out = '$time', total_duration = '$ttldurtoupdt',slab_name = '$slabName' ,slab_id = '$slabId', amount = '$totalamount', helmet_amount = '$helmetcharge', out_username = '$UID' WHERE trn_id ='$CID'";
mysqli_query($con,$trnupdatestmt);
if ($con->query($trnupdatestmt) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $con->error;
}
?>