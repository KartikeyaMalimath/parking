<?php

session_start();
include ('../include/db.php');
include ('../include/data.php');
include ('adminViews/parkingnav.php');
$page = "home";
if(!isset($_SESSION['user']) || $_SESSION['access'] != 'user') {
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
    <script src="../include/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../include/instascan.min.js" ></script>


    <style>

    .card {
        margin-top: 15vh; 
        padding : 2vh; 
        width: 90%;
        color : white;

    }
        
    </style>
    
</head>
<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Sidebar-->
    <?php echo $parnavbar;?>

    <script>
        document.getElementById("ticket").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
        <div class= "row">
            <div class = "col-sm-6">
                <!--ticket form-->
                <div class="card reg" id="userRegCard" style="margin: 2% 6%; padding:5vh 7vh 5vh 7vh;">
                    <form class="frm" method="POST" action="../function/storeticket.php" >
                        <center><h4>Ticket System</h4></center>
                        <div class="form-group">
                            <label for="trnvhno">Vehicle Number</label>
                            <input type="text" class="form-control" name="trnvhno" id="trnvhno" tabindex="1" required autofocus>
                        </div> 
                        <div class="form-group">
                            <label for="trsbtype">Vehicle type</label>
                            <select class="form-control" id="trsbtype" name="trsbtype" tabindex="2" required>
                                <?php 

                                    $query1 = "SELECT * ,count(vehicle_type) as countvhtyp FROM slab_master where flag = 1 AND active = 1 AND vehicle_type != 'helmet' GROUP BY vehicle_type ORDER BY COUNT(vehicle_type) DESC";
                                    $result1 = $con->query($query1);

                                    if($result1->num_rows > 0) {
                                        while($row = $result1-> fetch_assoc()) {
                                            $vid = $row['vehicle_type'];
                                            $forshort = "SELECT * FROM vehicle_type_master where flag = 1 AND active = 1 AND vtype_id = '$vid'";
                                            $shortres = $con->query($forshort);
                                            $shortrow = $shortres->fetch_assoc();


                                            echo   "<option value='".$vid."'>{$shortrow['shortcut']} - {$shortrow['vtype_name']}</option>";
                                        }

                                    }  
                                ?>
                            </select>
                        </div>  
                           
                        <div class="form-group">
                            <label for="trcname">Customer Name</label>
                            <input type="text" class="form-control" name="trcname" id="trcname" tabindex="3" placeholder="name">
                        </div> 
                        <div class="form-group">
                            <label for="trphone">Phone Number</label>
                            <input type="tel" pattern="[6-9]{1}[0-9]{9}" class="form-control" name="trphone" id="trphone" maxlength="10" tabindex="4">
                        </div>
                        <div class="form-group">
                            <label for="trhelsel">Helmet</label>
                            <select class="form-control" id="trhelsel" name="trhelsel" tabindex="5" onchange="helmetfocus()" required>
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="trhel">Number of helmets</label>
                            <input type="number" class="form-control" name="trhel" id="trhel" placeholder="disabled" tabindex="-1" disabled>
                        </div>
                        <div class="form-group">
                            <label for="trheladv">Helmet Advance Amount</label>
                            <input type="text" class="form-control" name="trheladv" id="trheladv" placeholder="disabled" tabindex="-1" disabled>
                        </div> 

                        <br>
                            
                        <div class="form-group">
                            <button type="submit" class="form-control" name="submit" id="submit" value="submit" >Submit</button>
                        </div>    
                    </form>
                </div>
                <!--ticket form end-->
            </div>
            <div class = "col-sm-6">
            <!--ticket display-->
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
            <!--ticket display end-->
            </div>
        </div> 
         
    </div>
    <!--=============================-->
</body>

<script>

function helmetfocus(){
    var e = document.getElementById("trhelsel");
    var selectedValue = e.options[e.selectedIndex].value;

    if(selectedValue == "yes")
    {
        document.getElementById("trheladv").disabled = false;
        document.getElementById("trheladv").tabindex = 7;
        document.getElementById("trheladv").placeholder = "Helmet advance in Rupees";

        document.getElementById("trhel").disabled = false;
        document.getElementById("trhel").tabindex = 6;
        document.getElementById("trhel").placeholder = "Number of Helmets";
    }else
    { 
        document.getElementById("trheladv").disabled = true;
        document.getElementById("trheladv").tabindex = -1
        document.getElementById("trheladv").placeholder = "disabled";

        document.getElementById("trhel").disabled = true;
        document.getElementById("trhel").tabindex = -1
        document.getElementById("trhel").placeholder = "disabled";
    }
}

$('body').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').not(':disabled');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});

function runsubmit(e){
    if (e.keyCode == 13) {
        form.submit();
    }
}

let scanner = new Instascan.Scanner(
    {
        video: document.getElementById('preview'), mirror:false
    }
);
scanner.addListener('scan', function(content) {
    //top.window.location = "../function/amount.php?id="+content;
    alert(content);s
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
