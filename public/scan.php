<?php

session_start();
include ('../include/db.php');
include ('../include/data.php');
include ('adminViews/scannav.php');
$page = "home";
if(!isset($_SESSION['user']) || $_SESSION['access'] != 'security') {
    echo "<script>top.window.location = '../function/logout.php'</script>";
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>

<html>
<head>
    <title><?php echo $loginTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/custom.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="../bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../include/instascan.min.js" ></script>

    <style>

    .card {
        margin-top: 2vh; 
        padding : 2vh; 
        width: 100%; 
        color : white;

    }
        
    </style>
    
</head>
<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Sidebar-->
    <?php echo $scannavbar;?>

    <script>
        document.getElementById("scan").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
        <div class= "row">
            <div class = "col-sm-6">
                <div class="card reg" >
                    <div class = "scan-col" >
                        <video id="preview" style="width:100%; height: auto;"></video>
                        <audio id="myAudio">
                            <source src="../include/beep-02.wav" type="audio/wav">
                        </audio>
                    </div>
                    <hr>
                    <h5><center>Scan Ticket QR Code</center></h5>
                </div>
            </div>
            <div class = "col-sm-6" >
            <!--Registration form-->
            
            <!--registration form end-->
            </div>
        </div>    
    </div>
    <!--=============================-->
</body>

<script>

let scanner = new Instascan.Scanner(
    {
        video: document.getElementById('preview'), mirror:false
    }
);
scanner.addListener('scan', function(content) {
    //top.window.location = "../function/amount.php?id="+content;
    alert(content);
});
Instascan.Camera.getCameras().then(cameras => 
{
    if(cameras.length == 1){
        scanner.start(cameras[0]);
    }
    else if(cameras.length == 2) {
        scanner.start(cameras[1]);
    }
    else {
        console.error("Error scanning");
    }
});

var aud = document.getElementById("myAudio"); 

function playAudio() { 
  audio.play(); 
}

</script>


</html>