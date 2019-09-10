<?php

//function to register new users
session_start();
include ('../include/db.php');
 //echo "test";
 if(isset($_POST['submit']))  
 {  
        //echo "submit";
      if(empty($_POST["username"]) || empty($_POST["password"]))  
      {  
           echo '<script>alert("Both Fields are required")</script>';  
      }  
      else  
      {  
            //echo "else";
            //create time stamp
            date_default_timezone_set('Asia/Kolkata'); 
            $t=time();
            $time = date("d-m-Y G:i:s", $t);
            //Create unique User Id
            $prefix = "fm";
            $userid = uniqid($prefix);

            $username = mysqli_real_escape_string($con, $_POST["username"]);  
            $password = mysqli_real_escape_string($con, $_POST["password"]);  
            $name = mysqli_real_escape_string($con, $_POST["fullname"]); 
            $phone = mysqli_real_escape_string($con, $_POST["phone"]); 
            $idtype = mysqli_real_escape_string($con, $_POST["idtype"]); 
            $idno = mysqli_real_escape_string($con, $_POST["idno"]);
            $empno = mysqli_real_escape_string($con, $_POST["empno"]);  
            $address = mysqli_real_escape_string($con, $_POST["address"]); 
            $usertype = mysqli_real_escape_string($con, $_POST["usertype"]); 
            //active / inactive
            $flag = 1;
            
            //password Hashing
            $password = password_hash($password, PASSWORD_DEFAULT);  
            //Inserting to database
            $query = "INSERT INTO user_master (user_id, uname, password, fullname, id_proof_type, id_number, emp_no, phone, address, type, flag, last_login) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";  
            $stmt = $con->prepare($query);
            $stmt->bind_param('ssssssssssds',$userid, $username, $password, $name, $idtype, $idno, $empno, $phone, $address, $usertype, $flag, $time);
            //echo "line1";

            if ($stmt->execute()) {
                //echo "line2";
                echo "<script type='text/javascript'>alert('User Created');</script>";
                echo "<script>top.window.location = '../public/admin.php'</script>";
                exit();
            }  else {
                
            //echo "Error : " . $con->error; // on dev mode only
            echo "<script>top.window.location = '../public/admin.php'</script>";
            
            // echo "Error, please try again later"; //live environment
            }
      }
      
      $con->close();
 }  else {
     echo "<script>top.window.location = '../public/admin.php'</script>";
 }

?>