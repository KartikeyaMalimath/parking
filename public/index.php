<?php

session_start();
include ('../include/db.php');
include ('../include/data.php');
include ('adminViews/navbar.php');
if(!isset($_SESSION['user']) || $_SESSION['access'] != 'admin') {
    echo "<script>top.window.location = '../function/logout.php'</script>";
}
$page = "home";
$user = $_SESSION['user'];

$stmt1 = "SELECT check_out, vehicle_type, count(vehicle_type) as countvhtyp FROM transaction_master GROUP BY vehicle_type ORDER BY COUNT(vehicle_type) DESC";
$res1 = $con->query($stmt1);

?>

<!-- Index.php for Public folder !!!!WARNING!!! -->

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $loginTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/custom.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/card.css">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <script src="../bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="../include\sweetalert.min.js"></script>
    <script type="text/javascript" src="../include/loader.js"></script>

    <script>
        function visible() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        
    </script>
    
</head>
<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Sidebar-->
    <?php echo $navbar;?>

    <script>
        document.getElementById("home").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
        <div class= "row">
            <div class = "col-sm-4" >
            <!--Column 1-->
            <div class="card">
                <div class="card-container">
                    <div class = "icn"><center>
                        <img src="icons/notes.png" width="50" height="50">
                    </div></center>
                    <hr>
                    <center>
                    <div class="ctnt">
                        <h4><b>This Week</b></h4> 
                        <h5>Total Amount : ₹ <?php echo $weektotal; ?></h5>
                        <p>Parking Amount : ₹ <?php echo $weekamount; ?> <br>Helmet Amount : ₹ <?php echo $weekhelmet; ?> </p>
                    </div></center>                   
                </div>
            </div>
            <!--Column 1 end-->   
            </div>
            <div class = "col-sm-4" >
            <!--Column 2-->
            <div class="card">
                <div class="card-container"><center>
                    <div class = "icn">
                        <img src="icons/cashier.png" width="50" height="50">
                    </div></center>
                    <hr>
                    <center>
                    <div class="ctnt">
                        <h4><b>Today's Collection</b></h4> 
                        <h5>Total Amount : ₹ <?php echo $total; ?></h5>
                        <p>Parking Amount : ₹ <?php echo $amount; ?> <br>Helmet Amount : ₹ <?php echo $helmet; ?> </p>
                    </div></center>                   
                </div>
            </div>
            <!--Column 2 end-->
            </div>
            <div class = "col-sm-4" >
            <!--Column 3-->
            <div class="card">
                <div class="card-container">
                    <div class = "icn">
                        <center><img src="icons/bank.png" width="50" height="50"></center>
                    </div>
                    <hr>
                    <center>
                    <div class="ctnt">
                        <h4><b>Collection till now</b></h4> 
                        <h5>Total Amount : ₹ <?php echo $trntotal; ?></h5>
                        <p>Parking Amount : ₹ <?php echo $trnamount; ?> <br>Helmet Amount : ₹ <?php echo $trnhelmet; ?> </p>
                        
                    </div></center>                    
                </div>
            </div>
            <!--Column 3 end-->
            </div>
        </div>    
        <!-- row 2 -->
        <div class= "">
            <div class = "chart-col ">
            <!--Column 1-->
            <div class="card chart-card">
                <div class="card-container">
                <center><h4>Average Vehicle Density</h4></center>
                    <div class="piechart" id="piechart"></div>
                </div>
            </div>
            <!--Column 1 end-->   
            </div>
            <div class = "chart-col" >
            <!--Column 2-->
            <div class="card chart-card">
                <div class="card-container">
                    <center><h4>Vehicles Parked</h4></center>
                    <div class="piechart2" id="piechart2"></div>
                </div>
            </div>
            <!--Column 2 end-->
            </div>
        </div>
        <!-- row 2 end -->
    </div>
    <!--=============================-->
</body>

<script type="text/javascript">

//Script to delete users
function del(Clicked_id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this User",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal({title: "User Deleted!",
                    icon: "success",
                    button: "OK",})
            .then(() => {
            window.location.href = ("../function/delete.php?id="+Clicked_id+"&page=admin");
            });
            
        } else {
            swal("User is Safe!");
        }
    });
}


// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);


// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Vehicle Type', 'Total Number']
  <?php 

        while ($row1 = $res1->fetch_assoc()){
            $vtypetemp = $row1['vehicle_type'];
                $gaadi = "SELECT * FROM vehicle_type_master WHERE vtype_id = '$vtypetemp'";
                $gaadires = $con->query($gaadi);
                $gaadirow = $gaadires->fetch_assoc();
            echo ",['{$gaadirow['vtype_name']}',{$row1['countvhtyp']} ]";
        }
        ?>

//   ['Work', 8],
//   ['Eat', 2],
//   ['TV', 4],
//   ['Gym', 2],
//   ['Sleep', 8]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Average Vehicle Types', };

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);

//2nd chart
    var data2 = google.visualization.arrayToDataTable([
    ['Vehicle Type', 'Number']    
    <?php 
    // $stmt2 = "SELECT * FROM transaction_master WHERE check_out == NULL";
    // $res2 = $con->query($stmt2);
    $stmt2 = "SELECT vehicle_type, count(vehicle_type) as countvhtyp FROM transaction_master WHERE check_out IS NULL GROUP BY vehicle_type ORDER BY COUNT(vehicle_type) DESC";
    $res2 = $con->query($stmt2);

    while ($row2 = $res2->fetch_assoc()) {
        // if($row1['check_out'] == NULL ) {
            $vtypetemp = $row2['vehicle_type'];
            $gaadi2 = "SELECT * FROM vehicle_type_master WHERE vtype_id = '$vtypetemp'";
            $gaadires2 = $con->query($gaadi2);
            $gaadirow2 = $gaadires2->fetch_assoc();
            echo ",[ '{$gaadirow2['vtype_name']}', {$row2['countvhtyp']} ]";
        // }
    }   
    
    ?>
// ,
//   ['Work', 8],
//   ['Eat', 2],
//   ['TV', 4],
//   ['Gym', 2],
//   ['Sleep', 8]
    ]);

    // Optional; add a title and set the width and height of the chart
    var options2 = {'title':'Total Vehicles in the Parking',};

    // Display the chart inside the <div> element with id="piechart"
    chart2 = new google.visualization.BarChart(document.getElementById('piechart2'));
    chart2.draw(data2, options2);
    }

</script>


</html>