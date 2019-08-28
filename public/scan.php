<!DOCTYPE html>

<?php

session_start();
include ('../include/db.php');
include ('../include/data.php');
include ('adminViews/scannav.php');
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
    <script type="text/javascript" src="../include/instascan.min.js" ></script>

    <script>
        

        
    </script>
    
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
            <div class = "col-sm-6" style="background-color:black;" >
                <video id="preview" style="width:100%; height: auto;"></video>
                <audio id="myAudio">
                    <source src="../include/beep-02.wav" type="audio/wav">
                </audio>
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
        video: document.getElementById('preview')
    }
);
scanner.addListener('scan', function(content) {
    alert('User Id: ' + content);
    top.window.location = "../function/calamount.php?id="+content;
});
Instascan.Camera.getCameras().then(cameras => 
{
    if(cameras.length > 0){
        scanner.start(cameras[0]);
    } else {
        console.error("Error scanning");
    }
});

var aud = document.getElementById("myAudio"); 

function playAudio() { 
  audio.play(); 
}

</script>


</html>