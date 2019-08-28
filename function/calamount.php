<?php

session_start();

include ('../include/db.php');

$UID = $_SESSION['userID'];
if(isset($_GET['id'])){
    $CID = $_GET['id'];

    //prepare timestamp for checkout time
    date_default_timezone_set('Asia/Kolkata'); 
    $t=time();
    $time = date("d-m-Y G:i:s", $t);

    //checkout date and time for buisness calculations
    $outdate = date('d/m/Y',$t);
    $outtime = date('G:i:s',$t);

    //check out time conversion to minutes for calculations
    $outhr = date('G',$t);
    $outmin = date('i',$t);
    $outtimeInMins = ($outhr * 60) +$outmin;
    //dev only
    echo "outdate = ".$outdate."outtime = ".$outtime;
    echo  "outhr :".$outhr." outmin:".$outmin."  Out totalmin : ".$outtimeInMins;

    
    $gettrn = "SELECT * FROM transaction_master WHERE trn_id = '$CID'";
    $trnres = $con->query($gettrn);
    $trnrow = $trnres->fetch_assoc();

    //In time retrival
    $intimefetch = $trnrow['check_in'];
    $intimedate = strtotime($intimefetch);
    $indate = date('d/m/Y',$intimedate);
    $intime = date('G:i:s',$intimedate);
    
    //intime conversion for calculation
    $inhr = date('G',$intimedate);
    $inmin = date('i',$intimedate);
    $intimeInMins = ($inhr * 60) + $inmin; 

    //dev only
    echo "indate : ".$indate."intime = :".$intime;
    echo "  inhr : ".$inhr."  inmin = ".$inmin."  Total in min:".$intimeInMins;

    //slab retrival
    $slabid = $trnrow['slab_id'];

    //get rates from slab table
    $getslab = "SELECT * FROM slab_master WHERE slab_id = '$slabid' AND flag = 1";
    $getslabres = $con->query($getslab);
    $getslabrow  = $getslabres->fetch_assoc();

    //fetch rates 
    $slabfrom = $getslabrow['slab_from'];
    $charge = $getslabrow['slab_charges'];

    //slab conversion to min
    $sfInMin = $slabfrom * 60;

    
//Amount calculations
    if($slabfrom === NULL){
        echo "noslab = ".$charge;
        if ($indate === $outdate){
            $sumAmount = $charge;
        }  
        else {
            $date1 = date_create($time);
            $date2 = date_create($intimefetch);
            $totaldays = date_diff($date1, $date2);
            $a = $totaldays->format('%a');

            $sumAmount = $a * $charge;
            //dev only
            echo "dates difference ".$a."........";
        }

    }
    else if ($slabfrom != NULL){
        $slabto = $getslabrow['slab_to'];
        //slabto in minutes
        $stInMin = $slabto * 60;
        //total slab duration
        $ttlsdInMin = $stInMin - $sfInMin;
        echo "slab duration in min:".$ttlsdInMin; 

        $addslabdur = $getslabrow['slab_add_dur'];
        //additional hour slab if exsists;
        if($addslabdur != NULL){
            $asdInMin = $addslabdur * 60;
            echo "additional slab : ".$asdInMin;
        }
        //if just slab duration is present
        else if ($addslabdur === NULL) {
            
        }
    }
    
}

?>