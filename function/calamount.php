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
    $outdate = date('d-m-Y',$t);
    $outtime = date('G:i:s',$t);

    //check out time conversion to minutes for calculations
    $outhr = date('G',$t);
    $outmin = date('i',$t);
    $outtimeInMins = ($outhr * 60) +$outmin; 
    //dev only
        //echo "outdate = ".$outdate."outtime = ".$outtime;
        //echo  "outhr :".$outhr." outmin:".$outmin."  Out totalmin : ".$outtimeInMins;
       

    
    $gettrn = "SELECT * FROM transaction_master WHERE trn_id = '$CID'";
    $trnres = $con->query($gettrn);
    $trnrow = $trnres->fetch_assoc();

    //In time retrival
    $intimefetch = $trnrow['check_in'];
    $intimedate = strtotime($intimefetch);
    $indate = date('d-m-Y',$intimedate);
    $intime = date('G:i:s',$intimedate);

    //dev date check
        //$indate = '28-08-2019';
        //$intime = '00:00:00';
    
    //intime conversion for calculation
    $inhr = date('G',$intimedate);
    $inmin = date('i',$intimedate);
    $intimeInMins = ($inhr * 60) + $inmin; 

    //dev only
        // $intimeInMins = 1320;
        //echo "indate : ".$indate."intime = :".$intime;
        //echo "  inhr : ".$inhr."  inmin = ".$inmin."intime in min:".$intimeInMins;

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
    if($slabfrom == NULL){
        echo "noslab = ".$charge;
        if ($indate == $outdate){
            $sumAmount = $charge;
        }  
        else {
            $date1 = date_create($indate);
            $date2 = date_create($outdate);
            $totaldays = date_diff($date1, $date2);
            $a = $totaldays->format('%a');

            $sumAmount = $charge + ($a * $charge);
            //dev only
                //echo "dates difference ".$a."........";
        }

    }
    else if ($slabfrom != NULL){
        $slabto = $getslabrow['slab_to'];
        //slabto in minutes
        $stInMin = $slabto * 60;
        //total slab duration
        $ttlsdInMin = $stInMin - $sfInMin;

        

        //echo "slab duration in min:".$ttlsdInMin; 

        $addslabdur = $getslabrow['slab_add_dur'];
        //additional hour slab if exsists;
        if($addslabdur != NULL){
            $asdInMin = $addslabdur * 60;
            //dev
                // $intimeInMins = 660;
                // $outtimeInMins = 960;
            echo "additional slab : ".$asdInMin;
            //same checkin checkout date
            if ($indate === $outdate) {
                echo "add same date";
                $samedatetime = $outtimeInMins - $intimeInMins;
                echo "..same..".$samedatetime;
                if($samedatetime <= $ttlsdInMin){
                    $sumAmount = $charge;
                    echo "..just slab charge".$sumAmount;
                } 
                // for every additional hrs
                else {
                    //retrieve additional slab charge
                    $addcharge = $getslabrow['slab_add_charge'];
                    $samedatetime = $samedatetime - $ttlsdInMin;
                    $addparkslab = $samedatetime / $asdInMin;
                    $sumAmount = $charge + ($addcharge * ceil($addparkslab));
                    //dev
                        echo "...amount = ".$sumAmount;
                }
            } 
            //for different checkin checkout date
            else if($indate != $outdate){
                echo "add different date";
                $date1 = date_create($indate);
                $date2 = date_create($outdate);
                $totaldays = date_diff($date1, $date2);
                $a = $totaldays->format('%a');

                //dev
                    //$intimeInMins = 1260;

                $sumAmount = 0;
                $samedatetime = 1440 - $intimeInMins;
                //retrieve additional slab charge
                $addcharge = $getslabrow['slab_add_charge'];
                do {
                    
                    if($samedatetime <= $ttlsdInMin){
                        $sumAmount = $sumAmount + $charge;
                        echo "..just slab charge".$sumAmount;
                    } 
                    // for every additional hrs
                    else {
                        $samedatetime = $samedatetime - $ttlsdInMin;
                        $addparkslab = $samedatetime / $asdInMin;
                        $sumAmount = $sumAmount + $charge + ($addcharge * ceil($addparkslab));
                        //dev
                            echo "...amount = ".$sumAmount;
                    }
                    //dev
                        echo "..days amount".$sumAmount;
                    $samedatetime = 1440;
                    $a = $a-1;
                }while($a>0);
                //day of checkout
                $samedatetime = $outtimeInMins;
                if($samedatetime <= $ttlsdInMin){
                    $sumAmount = $charge;
                    echo "..just slab charge".$sumAmount;
                } 
                // for every additional hrs
                else {
                    //retrieve additional slab charge
                    $addcharge = $getslabrow['slab_add_charge'];
                    $samedatetime = $samedatetime - $ttlsdInMin;
                    $addparkslab = $samedatetime / $asdInMin;
                    $sumAmount = $sumAmount + $charge + ($addcharge * ceil($addparkslab));
                    //dev
                        echo "...amount = ".$sumAmount;
                }




            }
        }
        //if just slab duration is present
        else if ($addslabdur == NULL){
            //if checkin and checkout are on same date
            
            if($indate == $outdate){
                $samedatetime = $outtimeInMins - $intimeInMins;
                echo "Total Parking time".$samedatetime;
                $totalparkslab = $samedatetime / $ttlsdInMin;
                //amount per slab hrs on same date
                $sumAmount = $charge + ($charge * floor($totalparkslab));
                //dev
                    //echo " total amount ".$sumAmount;
            }
            //if checkin dates and checkout dates are different
            else if($indate != $outdate){
                $date1 = date_create($indate);
                $date2 = date_create($outdate);
                $totaldays = date_diff($date1, $date2);
                $a = $totaldays->format('%a');
                
                //calculate total parking hr with with time resetting on each day

                $totalparkslab = (1440-$intimeInMins) / $ttlsdInMin;
                //dev
                    //echo $intimeInMins."--".$totalparkslab;
                while($a > 1){
                    $totalparkslab = $totalparkslab + (1440 / $ttlsdInMin);
                    //dev
                        //echo "--".$totalparkslab;
                    $a = $a-1;
                }
                $totalparkslab = $totalparkslab + ($outtimeInMins / $ttlsdInMin);
                //dev
                    //echo "--".$totalparkslab;
                $sumAmount = $charge + ($charge * floor($totalparkslab));
                //dev
                    //echo " onlyhaha ".$sumAmount;
                
            }
        }
    }
    echo "Total Amount = ".$sumAmount;
}

?>