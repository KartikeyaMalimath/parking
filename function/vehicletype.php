<?php

session_start();

$UID = $_SESSION['userID'];

include ('../include/db.php');
 echo "test";
 if(isset($_POST['submit']))  
 {  
        echo "submit";
      if(empty($_POST["vhtype"]))  
      {  
           echo '<script>alert("Fields are required")</script>';  
      }  
      else  
      {     
            //dev mode test only
                echo "else";

            //create time stamp
            date_default_timezone_set('Asia/Kolkata'); 
            $t=time();
            $time = date("d-m-Y G:i:s", $t);
            //Create unique Vehicle Id
            $prefix = "vtyp";
            $vhid = uniqid($prefix);

            $vhtype = mysqli_real_escape_string($con, $_POST["vhtype"]);  
            
            //active / inactive
            $flag = 1;
            
            //Inserting to database
            $query = "INSERT INTO vehicle_type_master (vtype_id, vtype_name, flag, created_date, created_by) VALUES(?,?,?,?,?)";  
            $stmt = $con->prepare($query);
            $stmt->bind_param('ssdss',$vhid,$vhtype,$flag,$time,$UID);
            echo "line1";

            if ($stmt->execute()) {
                echo "line2";
                echo "<script type='text/javascript'>alert('Vehicle Type Created');</script>";
                echo "<script>top.window.location = '../public/vehicles.php'</script>";
                exit();
            }  else {
                
            //echo "Error : " . $con->error; // on dev mode only
            echo "<script>top.window.location = '../public/vehicles.php'</script>";
            
            // echo "Error, please try again later"; //live environment
            }
      }
      
      $con->close();
 }  else {
     echo "<script>top.window.location = '../public/vehicles.php'</script>";
 }

?>