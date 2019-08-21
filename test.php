<?php

$con = mysqli_connect("localhost:3306","root","admin");
if(!$con){
    die("connection failed".mysqli_connect_error());
}
else{ 
    echo "connected";

    require 'latte.php';
    $latte = new Latte\Engine;
    $latte->setTempDirectory('/dump');
    $paramaters['var'] = "This is Title";
    $html = $latte->renderToString('test.latte',$paramaters);

}
?>                                              