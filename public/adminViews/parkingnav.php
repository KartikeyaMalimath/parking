<?php

$user = $_SESSION['user'];

$parnavbar =   "<div class='sidebar'>
                <center><img class='imglogo' src='../images/loginBG.jpg'></center>
                <center><p style='color: white;'>".$user."</p></center>
                <a href='../function/logout.php'><i class='fa fa-fw fa-user'></i>Logout</a>
                <a href='parking.php' id='ticket' >Ticket</a>
                <a href='about.php' id = 'about'>About</a>
            </div>"

?>