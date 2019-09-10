<?php

session_start();
include ('../include/db.php');
include ('../include/data.php');
include ('adminViews/navbar.php');
if(!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    echo "<script>top.window.location = '../function/logout.php'</script>";
}
$page = "home";
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
<!-- fetch company details -->
<?php

    $query1 = "SELECT * FROM company_master where flag = '1' AND company_id = 'fm5d7534212edbd' ";
    $result1 = $con->query($query1);
    $row = $result1-> fetch_assoc();

    $coname = $row['company_name'];
    $coaddress = $row['company_address'];
    $coown = $row['owner_name'];
    $costart = $row['validity_start'];
    $coexp = $row['validity_end'];
    $copos = $row['postal_code'];
    $cogps = $row['location_gps'];

?>


<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Sidebar-->
    <?php echo $navbar;?>

    <script>
        document.getElementById("company").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
    <div class= "row">
        <div class = "col-sm-6" >
            <div class="card">
                <img src="../images/fm5d7534212edbd.png" alt="Avatar" style="width:100%">
                <hr>
                <div class="container">
                    <center><h4><b><?php echo $coown; ?></b></h4> 
                    <p><b><?php echo $coname; ?></b></p></center> 
                </div>
            </div>
        </div>  
        <div class = "col-sm-6" >
            <div class="card">
                <div class="container">
                    <h4><b><center><?php echo $coown; ?></center></b></h4> 
                    <br><hr><br>
                    <p><b>Address : </b><?php echo $coaddress; ?></p> 
                    <p><b>Postal Code : </b><?php echo $copos; ?></p>
                    <p><b>Validity Start : </b><?php echo $costart; ?></p>
                    <p><b>Validity Expiry : </b><?php echo $coexp; ?></p>
                    <p><b>GPS location : </b><a href="<?php echo $cogps; ?>"> <?php echo $coname.' location'; ?></a></p>
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