<?php

session_start();
include ("../include/db.php");

$UID = $_SESSION['userID'];

if(isset($_GET['id'])){
    $CID = $_GET['id'];

    //capture current time for checkout
    date_default_timezone_set('Asia/Kolkata'); 
    $t=time();
    $time = date("d-m-Y G:i:s", $t);

    //prepare outdate for calculation
    $indate = date_create($time);
    //dev only
        //$indate = date_create("30-08-2019 22:00:00");

    //fetch customer transaction details
    $gettrn = "SELECT * FROM transaction_master WHERE trn_id = '$CID'";
    $trnres = $con->query($gettrn);
    $trnrow = $trnres->fetch_assoc();

    //check Helmet
    $helmetno = 0;

    $helmetno = $helmetno + $trnrow['helmet'];
    $heladv = $trnrow['helmet_advance'];
    
    //echo $helmetno;

    //check amount paid or not
    $checkamount = $trnrow['amount'];
    if ($checkamount != NULL) {
        echo "<script>top.window.location = '../public/scan.php'</script>";
        exit;
    }

    //fetch vehicle type
    $vhtype = $trnrow['vehicle_type'];

    //In time retrival
    $intimefetch = $trnrow['check_in'];
    $intimedate = strtotime($intimefetch);
    $indatetimecon = date("d-m-Y G:i:s",$intimedate);

    //prepare indate for calculation
    $outdate = date_create($indatetimecon);
    //dev only
        //$outdate = date_create("01-09-2019 00:00:00");

    //duration calculation
    $totaldays = date_diff($indate, $outdate);
    $days = $totaldays->format('%a');
    $hrs = $totaldays->format('%h');
    $mins = $totaldays->format('%i');

    //total duration
    $totaldur = $days*1440 + $hrs * 60 + $mins;
    $ttldurtoupdt = $totaldur;
    //5 min grace period
    if($totaldur > 5) {
        $totaldur = $totaldur - 5;
    }

    if($totaldur <= 1440 ) {
        //calculate amount for less than a day
        //fetch slab details
        //echo $durinhrs;
        $getslab = "SELECT * FROM slab_master WHERE vehicle_type = '$vhtype' AND flag = 1 AND (slab_from * 60) < $totaldur AND (slab_to * 60) >= $totaldur";
        $getslabres = $con->query($getslab);
        $getslabrow  = $getslabres->fetch_assoc();
        //helmet charges if present
        if ($helmetno > 0) {
            $gethelslab = "SELECT * FROM slab_master WHERE vehicle_type = 'helmet' AND flag = 1 AND (slab_from * 60) < $totaldur AND (slab_to * 60) >= $totaldur";
            $gethelslabres = $con->query($gethelslab);
            $gethelslabrow  = $gethelslabres->fetch_assoc();
            $helmetcharge = $gethelslabrow['slab_charges'] * $helmetno;
            //dev only
            echo " hel ".$helmetcharge." helclose ";
        }
        
        //fetch slab required details
        $slabId = $getslabrow['slab_id'];
        $slabName = $getslabrow['slab_name'];

        
        //get slab charges
        $slabCharge = $getslabrow['slab_charges'];
        $totalamount = $slabCharge;
    } 
    else if ($totaldur > 1440) {
        //Calculate amount for more than one day
        $totalamount = 0;
        $helmetcharge = 0;
        while($totaldur > 1440) {
            //fetch slab details
            $getslab = "SELECT * FROM slab_master WHERE vehicle_type = '$vhtype' AND flag = 1 AND (slab_to * 60) = 1440";
            $getslabres = $con->query($getslab);
            $getslabrow  = $getslabres->fetch_assoc();
            //fetch slab required details
            $slabId = $getslabrow['slab_id'];
            $slabName = $getslabrow['slab_name'];
            //get slab charges
            $slabCharge = $getslabrow['slab_charges'];
            $totalamount = $totalamount + $slabCharge;

            //helmet if present for multiple days
            if ($helmetno > 0) {
                $gethelslab = "SELECT * FROM slab_master WHERE vehicle_type = 'helmet' AND flag = 1 AND (slab_to * 60) = 1440";
                $gethelslabres = $con->query($gethelslab);
                $gethelslabrow  = $gethelslabres->fetch_assoc();
                $helmetcharge = $helmetcharge + ( $gethelslabrow['slab_charges'] * $helmetno );
                //dev only
                echo " hel ".$helmetcharge." helclose ";
            }

            //
            $totaldur -= 1440;
            //dev only
                //echo "test";
            echo $totalamount." ";
        }
        //
        $getslab = "SELECT * FROM slab_master WHERE vehicle_type = '$vhtype' AND flag = 1 AND (slab_from * 60) < $totaldur AND (slab_to * 60) >= $totaldur";
        $getslabres = $con->query($getslab);
        $getslabrow  = $getslabres->fetch_assoc();

        $slabCharge = $getslabrow['slab_charges'];
        //final total amount for multiple days
        $totalamount = $totalamount + $slabCharge;

        

        if ($helmetno > 0) {
            $gethelslab = "SELECT * FROM slab_master WHERE vehicle_type = 'helmet' AND flag = 1 AND (slab_from * 60) < $totaldur AND (slab_to * 60) >= $totaldur";
            $gethelslabres = $con->query($gethelslab);
            $gethelslabrow  = $gethelslabres->fetch_assoc();
            $helmetcharge = $helmetcharge + ( $gethelslabrow['slab_charges'] * $helmetno );
            //dev only
            echo " hel ".$helmetcharge." helclose ";
            echo $totalamount." ";
        }

    }
    
 
    echo " final amount : ".$totalamount;
    echo " final helmet amount : ".$helmetcharge;

    $helmetcharge = $helmetcharge - $heladv;
    echo "removing advance : ".$helmetcharge;
    
    

    //update transaction 
    $trnupdatestmt = "UPDATE transaction_master SET check_out = '$time', total_duration = '$ttldurtoupdt', amount = '$totalamount', helmet_amount = '$helmetcharge', out_username = '$UID' WHERE trn_id ='$CID'";
    mysqli_query($con,$trnupdatestmt);
    if ($con->query($trnupdatestmt) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $con->error;
    }


} 
else {
    echo "<script>top.window.location = '../public/scan.php'</script>";
}


?>