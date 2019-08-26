<?php

include ('../include/db.php');
//session
session_start();
$_SESSION = array();

if(isset($_POST["submit"]))  
 {  
      if(empty($_POST["username"]) || empty($_POST["password"]))  
      {  
           echo '<script>alert("Both Fields are required")</script>';  
           echo "<script>top.window.location = '../index.php'</script>";
      }  
      else  
      {     
          //prepare timestamp to update last login
            date_default_timezone_set('Asia/Kolkata'); 
            $t=time();
            $time = date("d-m-Y G:i:s", $t);

           $username = mysqli_real_escape_string($con, $_POST["username"]);  
           $password = mysqli_real_escape_string($con, $_POST["password"]);  
           $query = "SELECT * FROM user_master WHERE uname = '$username'";  
           $result = mysqli_query($con, $query);  
           if(mysqli_num_rows($result) > 0)  
           {  
                while($row = mysqli_fetch_array($result))  
                {  
                    //check hashed password
                     if(password_verify($password, $row["password"]))  
                     {  
                          //return true;   
                          $sqql = "SELECT * from user_master where uname = '$username'";
                          $result3 = $con->query($sqql);
                          if (!$result3) {
                              trigger_error('Invalid query: '.$con->error);
                          }
                          while($row =$result3->fetch_assoc()) {
                            $permission = $row['type'];
                            $setUser = $row['uname'];
                            $UID = $row['user_id'];
                            //Set Sessions based on access Rights and Username
                            $_SESSION['access'] = $permission;
                            $_SESSION['user'] = $setUser;
                            $_SESSION['userID'] = $UID;
                            
                          }

                        //Update last login Timestamp

                        $loginTimeUpdate = "UPDATE user_master SET last_login = '$time' where uname = '$username'";
                        if($con->query($loginTimeUpdate) === TRUE) {

                          //login
                            //Admin Login
                            if($permission == 'admin') {
                                echo "<script>top.window.location = '../public/admin.php'</script>";

                            }
                            //User Login (Ticket Vendor)
                            elseif($permission == 'user')
                                echo "<script>top.window.location = '../test.php'</script>";
                            //Security Login (Ticket Checkout)
                            else 
                                echo "<script>top.window.location = '../deptpanel.php'</script>";
                        }
                     }  
                     else  
                     {  
                          //return false;  
                          
                          echo "<script>top.window.location = '../index.php'</script>";  
                     }  
                }  
           }  
           else  
           {  
                
                echo "<script>top.window.location = '../index.php'</script>";    
           }  
      }  
 }  
 ?>  