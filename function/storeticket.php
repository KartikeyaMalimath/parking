<?php

//function to register new users
session_start();

$UID = $_SESSION['userID'];

include ('../include/db.php');
 echo "test";
 if(isset($_POST['submit']))  
 {  
    echo "submit";
    if(empty($_POST["trnvhno"]) || empty($_POST["trsbtype"]))  
    {  
        echo '<script>alert("Both Fields are required")</script>';  
    }  
    else  
    {  
        echo "else";
        //create time stamp
        date_default_timezone_set('Asia/Kolkata'); 
        $t=time();
        $chkintime = date("d-m-Y G:i:s", $t);
        //Create unique User Id
        $prefix = "TKT";
        $trnid = uniqid($prefix);

        $vhno = mysqli_real_escape_string($con, $_POST["trnvhno"]);  
        $vhtype = mysqli_real_escape_string($con, $_POST["trsbtype"]);  
        $trname = mysqli_real_escape_string($con, $_POST["trcname"]); 
        $trphone = mysqli_real_escape_string($con, $_POST["trphone"]); 
        $trhel = mysqli_real_escape_string($con, $_POST["trhel"]); 
        if(!empty($_POST['trheladv']) )
            $trheladv = mysqli_real_escape_string($con, $_POST["trheladv"]);
        else
            $trheladv = '0';
        //active / inactive
        $flag = 1;

        //get slab details
        $slabstmt = "SELECT * FROM slab_master WHERE vehicle_type = '$vhtype'";
        $slabres = $con->query($slabstmt);
        $slbrow = $slabres->fetch_assoc();

        //slab name and id
        $vhslabname = $slbrow['slab_name'];
        $vhslabid = $slbrow['slab_id'];
        echo $vhslabname;
        //Inserting to database
        $query = "INSERT INTO transaction_master (trn_id, vehicle_no, vehicle_type, customer_name, customer_phone, check_in, slab_name, slab_id, helmet, helmet_advance, in_username) VALUES(?,?,?,?,?,?,?,?,?,?,?)";  
        $stmt = $con->prepare($query);
        $stmt->bind_param('sssssssssss', $trnid, $vhno, $vhtype, $trname, $trphone, $chkintime, $vhslabname, $vhslabid, $trhel, $trheladv, $UID);
        echo "line1";

        if ($stmt->execute()) {
            echo "line2";
            echo "<script>top.window.location = '../public/parking.php'</script>";
            exit();
        }  else {
            
        //echo "Error : " . $con->error; // on dev mode only
        echo "<script>top.window.location = '../public/parking.php'</script>";
        
        // echo "Error, please try again later"; //live environment
        }
    }
    
    $con->close();
}  else {
    echo "<script>top.window.location = '../public/parking.php'</script>";
}

?>