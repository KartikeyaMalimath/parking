<?php

$user = $_SESSION['user'];

$navbar =   "<div class='sidebar'>
                <center><img class='imglogo' src='../images/loginBG.jpg'></center>
                <center><p style='color: white;'>".$user."</p></center>
                <a href='../function/logout.php'><i class='fa fa-fw fa-user'></i>Logout</a>
                <a href='./' id='home'>Home</a>
                <a href='admin.php' id='user' >Users</a>
                <a href='vehicles.php' id = 'vehicles' >Vehicle types</a>
                <a href='slabs.php' id = 'slabs'>Slabs</a>
                <a href='pass.php' id = 'pass'>Pass</a>
                <a href='company.php' id = 'company'>Company</a>
                <a href='reports.php' id = 'reports'>Reports</a>
                <a href='settings.php' id = 'settings'>Settings</a>
                <a href='about.php' id = 'about'>About</a>
            </div>"

?>