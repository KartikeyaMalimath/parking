<?php
    session_start();
    $permission = $_SESSION['access'];
?>
<!DOCTYPE html>
<head>
    <script src='../include/sweetalert.min.js'></script>
    <script src="../include/jquery-3.4.1.min.js"></script>

</head>
<html>
<body style="background-color:#f2f2f2;">

<h2 id="h2">Checkout confirm</h2>

<script type="text/javascript">
var access = '<?php echo $permission; ?>';
</script>

</body>



<?php

include ("../include/db.php");

$UID = $_SESSION['userID'];

$com = $_SESSION['company'];
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

    $helid = $trnrow['helmet_id'];

    $helmetno = $helmetno + $trnrow['helmet'];
    $heladv = $trnrow['helmet_advance'];
    //echo $helmetno;

    //check amount paid or not
    $checkamount = $trnrow['amount'];
    if ($checkamount != '0') {
        echo "<script type='text/javascript'>
            swal({
                title: 'Amount Already Paid!',
                text: 'Transaction is already completed',
                icon: 'success',
                button: 'Continue!',
            }).then(() => {
                if(access == 'user'){
                    top.window.location = '../public/parking.php';  
                } else if(access == 'security') {
                    top.window.location = '../public/scan.php';  
                } else {
                    top.window.location = '../';
                }
            });
        </script>
        ";
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
        $getslab = "SELECT * FROM slab_master WHERE vehicle_type = '$vhtype' AND flag = 1 AND active = 1 AND (slab_from * 60) < $totaldur AND (slab_to * 60) >= $totaldur";
        $getslabres = $con->query($getslab);
        $getslabrow  = $getslabres->fetch_assoc();
        //helmet charges if present
        if ($helmetno > 0) {
            $gethelslab = "SELECT * FROM slab_master WHERE vehicle_type = '$helid' AND flag = 1 AND active = 1 AND (slab_from * 60) < $totaldur AND (slab_to * 60) >= $totaldur";
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
            $getslab = "SELECT * FROM slab_master WHERE vehicle_type = '$vhtype' AND flag = 1 AND active = 1 AND (slab_to * 60) = 1440";
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
                $gethelslab = "SELECT * FROM slab_master WHERE vehicle_type = '$helid' AND flag = 1 AND active = 1 AND (slab_to * 60) = 1440";
                $gethelslabres = $con->query($gethelslab);
                $gethelslabrow  = $gethelslabres->fetch_assoc();
                $helmetcharge = $helmetcharge + ( $gethelslabrow['slab_charges'] * $helmetno );
                //dev only
                    //echo " hel ".$helmetcharge." helclose ";
            }

            //
            $totaldur -= 1440;
            //dev only
                //echo "test";
                //echo $totalamount." ";
        }
        //
        $getslab = "SELECT * FROM slab_master WHERE vehicle_type = '$vhtype' AND flag = 1 AND active = 1 AND (slab_from * 60) < $totaldur AND (slab_to * 60) >= $totaldur";
        $getslabres = $con->query($getslab);
        $getslabrow  = $getslabres->fetch_assoc();

        $slabCharge = $getslabrow['slab_charges'];
        //final total amount for multiple days
        $totalamount = $totalamount + $slabCharge;

        

        if ($helmetno > 0) {
            $gethelslab = "SELECT * FROM slab_master WHERE vehicle_type = '$helid' AND flag = 1 AND active = 1 AND (slab_from * 60) < $totaldur AND (slab_to * 60) >= $totaldur";
            $gethelslabres = $con->query($gethelslab);
            $gethelslabrow  = $gethelslabres->fetch_assoc();
            $helmetcharge = $helmetcharge + ( $gethelslabrow['slab_charges'] * $helmetno );
            //dev only
                // echo " hel ".$helmetcharge." helclose ";
                // echo $totalamount." ";
        }

    }
    
 
    // echo " final amount : ".$totalamount;
    // echo " final helmet amount : ".$helmetcharge;

    if($helmetno > 0){
        $helmetcharge = $helmetcharge - $heladv;
        $amountdis = $totalamount + $helmetcharge;
        echo "hel : ".$helmetcharge;
    } 
    else {
        $amountdis = $totalamount;
        $helmetcharge = 0;
    }
    
    // echo "removing advance : ".$helmetcharge;
    // echo "slab_type : ".$slabId;

    //amount ot be paid for display
    
    // GST Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )
    // Net Price = Original Cost – GST Amount
    if($helmetno == 0){
        $gststmt = "SELECT gst_applicable FROM vehicle_type_master WHERE vtype_id = '$vhtype' AND flag = '1' AND active = '1'";
        $gstres = $con->query($gststmt);
        $gstrow = $gstres->fetch_assoc();

        $gstapp = $gstrow['gst_applicable'];
        if($gstapp == 1){
            $stmt = "SELECT cgst, sgst FROM company_master WHERE company_id = '$com'";
            $res = $con->query($stmt);
            $row = $res->fetch_assoc();

            $cgst = ($totalamount) - (($totalamount) * (100 / (100 + $row['cgst'])));
            $sgst = ($totalamount) - (($totalamount) * (100 / (100 + $row['sgst'])));
            $gst = $cgst + $sgst;
        } else {
            $cgst = 0;
            $sgst = 0;
            $gst = 0;
        }
    }
    else {
        $gststmt = "SELECT gst_applicable FROM vehicle_type_master WHERE vtype_id = '$vhtype' AND flag = '1' AND active = '1'";
        $gstres = $con->query($gststmt);
        $gstrow = $gstres->fetch_assoc();

        $gstapp = $gstrow['gst_applicable'];

        $gsthelstmt = "SELECT gst_applicable FROM vehicle_type_master WHERE vtype_id = '$helid' AND flag = '1' AND active = '1'";
        $gsthelres = $con->query($gsthelstmt);
        $gsthelrow = $gsthelres->fetch_assoc();

        $gsthelapp = $gsthelrow['gst_applicable'];

        if($gstapp == 1){
            $stmt = "SELECT cgst, sgst FROM company_master WHERE company_id = '$com'";
            $res = $con->query($stmt);
            $row = $res->fetch_assoc();
            if($gsthelapp == 1){
                $cgst = ($totalamount + $helmetcharge + $heladv) - (($totalamount + $helmetcharge + $heladv) * (100 / (100 + $row['cgst'])));
                $sgst = ($totalamount + $helmetcharge + $heladv) - (($totalamount + $helmetcharge + $heladv) * (100 / (100 + $row['sgst'])));
                $gst = $cgst + $sgst;
            } else {
                $cgst = ($totalamount) - (($totalamount) * (100 / (100 + $row['cgst'])));
                $sgst = ($totalamount) - (($totalamount) * (100 / (100 + $row['sgst'])));
                $gst = $cgst + $sgst;
            }
        } else {
            if($gsthelapp == 1){
                $cgst = ($helmetcharge + $heladv) - (($helmetcharge + $heladv) * (100 / (100 + $row['cgst'])));
                $sgst = ($helmetcharge + $heladv) - (($helmetcharge + $heladv) * (100 / (100 + $row['sgst'])));
                $gst = $cgst + $sgst;
            } else {
                $cgst = 0;
                $sgst = 0;
                $gst = 0;
            }
        }

    }

    // $stmt = "SELECT cgst, sgst FROM company_master WHERE company_id = '$com'";
    // $res = $con->query($stmt);
    // $row = $res->fetch_assoc();

    // $cgst = ($totalamount + $helmetcharge + $heladv) - (($totalamount + $helmetcharge + $heladv) * (100 / (100 + $row['cgst'])));
    // $sgst = ($totalamount + $helmetcharge + $heladv) - (($totalamount + $helmetcharge + $heladv) * (100 / (100 + $row['sgst'])));
    // $gst = $cgst + $sgst;
    

    
    echo round($cgst,3)." ".round($sgst,3)." ".round($gst,5);
} 
else {
    echo "<script>top.window.location = '../public/scan.php'</script>";
}


?>
<!-- JS alert display for payment confirmation -->
<script>
function ajaxcalll(time, ttldur, amount, helcharge, cid, slabid, slabnm ) {    
    $.ajax({ 
        url: 'transaction.php',
        data: {"time" : time ,"ttldur" : ttldur, "amount" : amount, "helcharge" : helcharge, "cid" : cid, "slabid" : slabid, "slabnm" : slabnm, "cgst" : cgst, "sgst": sgst, "gst": gst},
        type: 'POST',
        success: function() { 
            if(access == 'user'){
                top.window.location = '../public/parking.php';  
            } else if(access == 'security') {
                top.window.location = '../public/scan.php';  
            } else {
                top.window.location = '../';
            }
        },
        error: function (request, error) {alert(" error Please contact vendor "); }
    });
}

var t = '<?php echo $time ?>';
var ttl = '<?php echo $ttldurtoupdt ?>';
var amt = '<?php echo $totalamount ?>';
var hel = '<?php echo $helmetcharge ?>';
var c = '<?php echo $CID ?>';
var sl = '<?php echo $slabId ?>';
var snm =  '<?php echo $slabName ?>';
var cgst =  '<?php echo round($cgst,3) ?>';
var sgst =  '<?php echo round($sgst,3) ?>';
var gst =  '<?php echo round($gst,3) ?>';

setTimeout(function() {
    swal({
        title: 'Total Amount : <?php echo $amountdis ?>',
        text: 'Parking amount : <?php echo $totalamount ?>\nHelmet charges : <?php echo $helmetcharge ?>',
        icon: 'warning',
        buttons: ['Not paid', ' paid '],
        
    })
    .then((willpay) => {
        if (willpay) {
        swal({
            title: 'Amount Paid',
            text: 'Transaction completed',
            icon: 'success',
            button: 'Done!',
        }).then((paid) => {
            if(paid) {
                
                ajaxcalll(t,ttl,amt,hel,c,sl,snm,cgst,sgst,gst);
            }            
        });
        } else {
            if(access == 'user'){
                top.window.location = '../public/parking.php';  
            } else if(access == 'security') {
                top.window.location = '../public/scan.php';  
            } else {
                top.window.location = '../';
            }
        }
    });
}, 200);



</script>
</html>

