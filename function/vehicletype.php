<?php

session_start();

echo "<script src='../include/sweetalert.min.js'></script>";

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
            $shkey = mysqli_real_escape_string($con, $_POST["skey"]);  
            
            //active / inactive
            $flag = 1;
            $active = 1;
            //Inserting to database
            $query = "INSERT INTO vehicle_type_master (vtype_id, vtype_name, flag, created_date, created_by, shortcut, active) VALUES(?,?,?,?,?,?,?)";  
            $stmt = $con->prepare($query);
            $stmt->bind_param('ssdsssd',$vhid,$vhtype,$flag,$time,$UID,$shkey,$active);
            echo "line1";

            if ($stmt->execute()) {
                echo "<script type='text/javascript'>
                    swal({
                    title: 'Vehicle type Created!',
                    icon: 'success',
                    }).then((value) => {
                        top.window.location = '../public/vehicles.php';
                    });
                        
                </script>";
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