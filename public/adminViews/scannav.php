<?php

$user = $_SESSION['user'];

$scannavbar =   "<div class='sidebar'>
                <center><img class='imglogo' src='../images/loginBG.jpg'></center>
                <center><p style='color: white;'>".$user."</p></center>
                <a href='../function/logout.php'><i class='fa fa-fw fa-user'></i>Logout</a>
                <a href='scan.php' id='scan' >Scan QR</a>
                <a href='about.php' id = 'about'>About</a>
            </div>"

?>