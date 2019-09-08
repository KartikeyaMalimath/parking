<!DOCTYPE html>

<?php

session_start();
include ('../include/db.php');
include ('../include/data.php');
include ('adminViews/navbar.php');
include ('adminViews/scannav.php');
include ('adminViews/parkingnav.php');
if(!isset($_SESSION['user'])) {
    echo "<script>top.window.location = '../function/logout.php'</script>";
}
$page = "home";
$user = $_SESSION['user'];
?>

<html>
<head>
    <title><?php echo $loginTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/custom.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="../bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="../include\sweetalert.min.js"></script>

    <style>
    body {
        
    }
    .card {
        padding : 5vh;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 90%;
        margin: 5%;
    }

    .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .container {
    padding: 2px 16px;
    }
    
    </style>
    
</head>



<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Sidebar-->
    <?php 

    if ($user == 'admin') {
        echo $navbar;
    } 
    else if ($user == 'user') {
        echo $parnavbar;
    }
    else if ($user == 'security') {
        echo $scannavbar;
    } else {
        echo "Warning! System Problem - IP address has been reported";
    }
    ?>
    

    <script>
        document.getElementById("about").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
    <div class= "row">
        <div class = "col-sm-6" >
            <div class="card">
                <img src="../images/FM.png" alt="Avatar" style="width:100%">
                <hr>
                <div class="container">
                    <center><h4><b>Fusion Minds Technologies Pvt Ltd.</b></h4> </center> 
                    <br>
                    <p><b>Address : </b><br>1067, Akkamahadevi Rd, Dwarasamudra, 2nd Stage, JP Nagar, Mysuru, Karnataka.</p>
                    <p><b>Pin Code : </b><br>570031</p>
                </div>
            </div>
        </div>
        <div class = "col-sm-6" >
            <div class="card">
                <div class="container">
                    <h4><b><center>Developers Team</center></b></h4> 
                    <br><hr><br>
                    <p><b>Name : </b></p> 
                    <p><b>Name : </b></p> 
                    <p><b>Name : </b></p> 
                    <p><b>Name : </b></p> 
                    
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--=============================-->
</body>

<script>



</script>


</html>