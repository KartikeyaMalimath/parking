<!DOCTYPE html>

<?php

session_start();
include ('../include/db.php');
include ('../include/data.php');
include ('adminViews/navbar.php');
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
        document.getElementById("vehicles").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
        <div class= "row">
            <div class = "col-sm-7" >
                <table class='content-table' style="margin-top:10vh">
                    <thead>
                        <tr>
                        <th>Vehicle Type</th>
                        <th>Created On</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            $query1 = "SELECT * FROM vehicle_type_master where flag = '1'";
                            $result1 = $con->query($query1);

                            if($result1->num_rows > 0) {
                                while($row = $result1-> fetch_assoc()) {
                                    $vhid = $row['vtype_id'];
                                    $temp0 = $row['created_date'];
                                    $createddate = strtotime($temp0);
                                    echo   "<tr>
                                                <td>{$row['vtype_name']}</td>
                                                <td>".date('d/m/Y',$createddate)."</td>
                                                <td><button class = 'btn btn-danger' style='width: 100%;' type='button' id= ".$vhid." onclick='#'>Delete</button></td>
                                            </tr>";
                                }

                            }  
                        ?>
                    </tbody>
                </table>
            </div>
            <div class = "col-sm-5" >
            <!--Registration form-->
            <div class="card reg" id="userRegCard">
                <form class="frm" method="POST" action="../function/vehicletype.php" >
                    <center><h4>Vehicle Types</h4></center>
                    <div class="form-group">
                        <label for="vhtype">Vehicle Type</label>
                        <input type="text" class="form-control" name="vhtype" id="vhtype" placeholder = "eg: SUV, Bike, auto.."required>
                    </div>     
                    
                    <br>
                        
                    <div class="form-group">
                        <input type="submit" class="form-control" name="submit" id="submit" value="submit">
                    </div>    
                </form>
            </div>
            <!--registration form end-->
            </div>
        </div>    
    </div>
    <!--=============================-->
</body>
</html>