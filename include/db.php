<?php

$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "parking";

$con = mysqli_connect($servername, $username, $password, $dbname);
if(!$con){
    die("connection failed".mysqli_connect_error());
}
else{ 
    //development only
    //echo "connected";
}

?>