<?php

session_start();
$_SESSION = array();

include ('include/db.php');
include ('include/data.php');



?>
<!DOCTYPE html>

<html>
<head>
    <title><?php echo $loginTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/custom.css">
    <link rel="stylesheet" href="public/css/login.css">
    <script src="bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

    <script>
        function visible() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        

        var goFS = document.getElementById("goFS");
        goFS.addEventListener("click", function() {
            document.body.requestFullscreen();
            document.body.webkitRequestFullScreen();
        }, false);

    </script>
    
</head>
<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <div class="row h-100" style="heigh:100%;">
    <!-- column for Image-->
        <div class = "col-sm-7" style="background-image:url('images/loginBG.jpg'); margin:0px;">
        <!-- <button id="goFS">Go fullscreen</button> -->
        </div>
    <!--column for login box-->
        <div class = "col-sm-5 shadow-sm login">
            <div>
                <form class="frm" method="POST" action ="function/login.php">
                    <div class="form-group">
                        <center><img src="images/<?php echo $company ?>.png" class="img-rounded logo" alt="Cinque Terre"></center>
                    </div>
                    <br>
                    <center><h4>Parking Login</h4></center>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>   
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div> 
                    <div class="form-group">
                        <input type="checkbox" onClick="visible()">
                        <label for="Shpassword">Show password</label>
                    </div>    
                    <div class="form-group">
                        <input type="Submit" class="form-control" name="submit" id="submit" value="submit">
                    </div>    
                </form>
            </div>
        </div>
    </div>

    <!--=============================-->
</body>
</html>