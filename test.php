<?php

$con = mysqli_connect("localhost:3306","root","admin");
if(!$con){
    die("connection failed".mysqli_connect_error());
}
else{ 
    echo "connected";
}
?>                                              