<?php

//function to register new slabs
session_start();

$UID = $_SESSION['userID'];

include ('../include/db.php');
 echo "test";
 if(isset($_POST['submit']))  
 {  
        echo "submit";
      if(empty($_POST["sbname"]) || empty($_POST["sbtype"]))  
      {  
           echo '<script>alert("All Fields are required")</script>';  
      }  
      else  
      {  
            echo "else";
            //create time stamp
            date_default_timezone_set('Asia/Kolkata'); 
            $t=time();
            $time = date("d-m-Y G:i:s", $t);
            //Create unique Slab Id
            $prefix = "sLb";
            $slabid = uniqid($prefix);

               
            $sbname = mysqli_real_escape_string($con, $_POST["sbname"]); 
            $sbtype = mysqli_real_escape_string($con, $_POST["sbtype"]); 
            $sbfrom = mysqli_real_escape_string($con, $_POST["sbfrom"]); 
            $sbto = mysqli_real_escape_string($con, $_POST["sbto"]); 
            $sbtype = mysqli_real_escape_string($con, $_POST["sbtype"]); 
            $sbadd = mysqli_real_escape_string($con, $_POST["sbadd"]); 
            $sbaddch = mysqli_real_escape_string($con, $_POST["sbaddch"]);
            $sbcharges = mysqli_real_escape_string($con, $_POST["sbcharge"]);
            
            //active / inactive
            $flag = 1;
            
            //password Hashing 
            //Inserting to database
            $query = "INSERT INTO slab_master (slab_id, slab_name, vehicle_type, slab_from, slab_to, slab_charges, flag, slab_add_dur, slab_add_charge, created_date, created_by) VALUES(?,?,?,?,?,?,?,?,?,?,?)";  
            $stmt = $con->prepare($query);
            $stmt->bind_param('ssssssdssss',$slabid, $sbname, $sbtype, $sbfrom, $sbto, $sbcharges, $flag, $sbadd, $sbaddch, $time, $UID);
            echo "line1";

            if ($stmt->execute()) {
                echo "line2";
                echo "<script type='text/javascript'>alert('Slab Created');</script>";
                echo "<script>top.window.location = '../public/slabs.php'</script>";
                exit();
            }  else {
                
            //echo "Error : " . $con->error; // on dev mode only
            echo "<script>top.window.location = '../public/slabs.php'</script>";
            
            // echo "Error, please try again later"; //live environment
            }
      }
      
      $con->close();
 }  else {
     echo "<script>top.window.location = '../public/slabs.php'</script>";
 }

?>