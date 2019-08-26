<?php

$con = mysqli_connect("localhost:3306","root","admin");
if(!$con){
    die("connection failed".mysqli_connect_error());
}
else{ 
    echo "connected";
    date_default_timezone_set('Asia/Kolkata'); 
    $t=time();
    echo(date("d-m-Y G:i:s",$t));

}
?>                                              
