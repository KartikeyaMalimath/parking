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
    <script src="../include/jquery-3.4.1.min.js"></script>
    <script src="../include/jquery.min.js"></script>
    <!-- style sheets -->
    <!-- <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/custom.css"> -->
    <link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/custom.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="../include/jquery.dataTables.min.css">
    <!-- bootstrap scripts -->
    
    <!-- <script src="../bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-3.3.6-dist/js/tether.min.js"></script>
    <script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <script src="../include/sweetalert.min.js"></script>
    <script src="../include/jquery.dataTables.min.js"></script>
    <script src="../include/dataTables.bootstrap.min.js"></script>
    
</head>
<!-- fetch company details -->
<?php

    $query1 = "SELECT * FROM transaction_master";
    $result1 = $con->query($query1);

?>


<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Sidebar-->
    <?php echo $navbar;?>

    <script>
        document.getElementById("reports").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content" style="padding: 2vh;">
    <div class="table-responsive" style=" padding: 50px;background-color:white;"> 
        <table id="transaction" class="table table-striped table-bordered" style="background-color: white; margin: 5vh auto;">
            <thead>
                <tr>
                    <th>Vehicle Number</th>
                    <th>Vehicle Type</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Total Duration</th>
                    <th>Amount</th>
                    <th>Helmet Amount</th>
                </tr>
            </thead>
            <tbody>
                
                    <?php
                    while ($row = $result1-> fetch_assoc()) {
                        if($row['helmet_advance'] == NULL){
                            $heladv = 0;
                        } else {
                            $heladv = $row['helmet_advance'];
                        }
                        if($row['helmet_amount'] == NULL){
                            $hel = 0;
                        } else {
                            $hel = $row['helmet_amount'];
                        }
                        $vhno = $row['vehicle_no'];
                        $vhtype = $row['vehicle_type'];
                        $trin = $row['check_in'];
                        $trout = $row['check_out'];
                        $trdur = round($row['total_duration']/60, 2 );
                        $tramt = $row['amount'];
                        
                        $trhel = $heladv + $hel;

                        //fetch vehicle type
                        $query2 = "SELECT * FROM vehicle_type_master WHERE vtype_id = '$vhtype' ";
                        $result2 = $con->query($query2);
                        $row2 = $result2->fetch_assoc();

                        $vhcle = $row2['vtype_name'];

                        echo "<tr>  <td>".$vhno."</td>
                                    <td>".$vhcle."</td>
                                    <td>".$trin."</td>
                                    <td>".$trout."</td>
                                    <td>".$trdur."</td>
                                    <td>".$tramt."</td>
                                    <td>".$trhel."</td></tr>";
                    }
                    
                    ?>
                
            </tbody>
        </table>
    </div>
    </div>
    <!--=============================-->
</body>

<script>

$(document).ready( function () {
    $('#transaction').DataTable();
} );

</script>


</html>