<?php

include ('db.php');

date_default_timezone_set('Asia/kolkata');
$t = time();
$curdatetime = date("d-m-Y G:i:s",$t);

$curdate = date("d-m-Y");

$loginTitle = "Parking ";

//Company Unique ID
$company = "fm5d7534212edbd";

//Data fetch for dashboard
$total = 0;
$helmet = 0;
$amount = 0;

$stmt1 = "SELECT * FROM transaction_master WHERE check_out LIKE '$curdate%'";
$res1 = $con->query($stmt1);
while($row1 = $res1->fetch_assoc()){
    // echo "{$row1['trn_id']}\n";
    if($row1['helmet_advance'] != NULL && $row1['helmet_amount'] != NULL)
    {   
        $helmet = $helmet + $row1['helmet_advance'] + $row1['helmet_amount'];
    }
    if($row1['amount'] != NULL){
        $amount = $amount + $row1['amount'];
    }
    
}
$total = $helmet+$amount;
//echo $helmet."  ".$amount."  ".$total;

//Weekly fetch dashboard
$startOfWeek = date("d-m-Y", strtotime("Monday this week"));

$weekamount = 0;
$weektotal = 0;
$weekhelmet = 0;

for ($i=0; $i<7;$i++){
    //echo date("d-m-Y", strtotime($startOfWeek . " + $i day"))."<br />";
    $tempdate = date("d-m-Y", strtotime($startOfWeek . " + $i day"));
    $stmt2 = "SELECT * FROM transaction_master WHERE check_out LIKE '$tempdate%'";
    $res2 = $con->query($stmt2);
    while($row2 = $res2->fetch_assoc()){
        // echo "{$row1['trn_id']}\n";
        if($row2['helmet_advance'] != NULL && $row2['helmet_amount'] != NULL) {
            $weekhelmet = $weekhelmet + $row2['helmet_advance'] + $row2['helmet_amount'];
        }
        
        if( $row2['amount'] != NULL) {
            $weekamount = $weekamount + $row2['amount'];
        }
    }
}
$weektotal = $weekhelmet + $weekamount;


// Total transaction amount

$trntotal =0;
$trnamount=0;
$trnhelmet = 0;
$stmt3 = "SELECT * FROM transaction_master";
$res3 = $con->query($stmt3);
while($row3 = $res3->fetch_assoc()){
    // echo "{$row1['trn_id']}\n";
    if($row3['helmet_advance'] != NULL && $row3['helmet_amount'] != NULL){
        $trnhelmet = $trnhelmet + $row3['helmet_advance'] + $row3['helmet_amount'];
    }
    if($row3['amount'] != NULL) {
        $trnamount = $trnamount + $row3['amount'];
    }
    
}
$trntotal = $trnhelmet + $trnamount;

?>