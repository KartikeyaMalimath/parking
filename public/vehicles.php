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
    <script src="../include/sweetalert.min.js"></script>
    <script src="../include/jquery-3.4.1.min.js"></script>

    
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
                            <th>Active Vehicles</th>
                        </tr>
                        <tr>
                        <th>Vehicle Type</th>
                        <th>Shortcut Key</th>
                        <th>Updated On</th>
                        <th>Deactivate</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            $query1 = "SELECT * FROM vehicle_type_master where flag = '1' AND active = '1'";
                            $result1 = $con->query($query1);

                            if($result1->num_rows > 0) {
                                while($row = $result1-> fetch_assoc()) {
                                    $vhid = $row['vtype_id'];
                                    $temp0 = $row['created_date'];
                                    $createddate = strtotime($temp0);
                                    echo   "<tr>
                                                <td>{$row['vtype_name']}</td>
                                                <td>{$row['shortcut']}</td>
                                                <td>".date('d/m/Y',$createddate)."</td>
                                                <td><button class = 'btn btn-info' style='width: 100%; color:white;' id= ".$vhid." onclick = 'deactivate(this.id)'>Deactivate</button></td>
                                                <td><a href='./vehicles.php?vhedit={$vhid}' class = 'btn btn-success' style='width: 100%; color : white; font-size : 12px;' id= ".$vhid.">Edit</a></td>                                                
                                                <td><button class = 'btn btn-danger' style='width: 100%;' type='button' id= ".$vhid." onclick='del(this.id)'>Delete</button></td>
                                            </tr>";
                                }

                            }  
                        ?>
                    </tbody>
                </table>
                <!-- Inactive Table -->
                <table class='content-table' style="margin-top:10vh">
                    <thead>
                        <tr>
                            <th>In-active Vehicles</th>
                        </tr>
                        <tr>
                        <th>Vehicle Type</th>
                        <th>Shortcut Key</th>
                        <th>Updated on</th>
                        <th>Activate</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            $query1 = "SELECT * FROM vehicle_type_master where flag = '1' AND active = '0'";
                            $result1 = $con->query($query1);

                            if($result1->num_rows > 0) {
                                while($row = $result1-> fetch_assoc()) {
                                    $vhid = $row['vtype_id'];
                                    $temp0 = $row['created_date'];
                                    $createddate = strtotime($temp0);
                                    echo   "<tr>
                                                <td>{$row['vtype_name']}</td>
                                                <td>{$row['shortcut']}</td>
                                                <td>".date('d/m/Y',$createddate)."</td>
                                                <td><button class = 'btn btn-info' style='width: 100%; color:white' id= ".$vhid." onclick='activate(this.id)'>Activate</button</td>
                                                <td><button class = 'btn btn-danger' style='width: 100%;' type='button' id= ".$vhid." onclick='del(this.id)'>Delete</button></td>
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
                    <div class="form-group">
                        <label for="skey">Shortcut Key</label>
                        <input type="text" class="form-control" name="skey" id="skey" placeholder = "eg: s ,b ,a.."required>
                    </div>    
                    
                    <br>
                        
                    <div class="form-group">
                        <input type="submit" class="form-control" name="submit" id="submit" value="submit">
                    </div>    
                </form>
            </div>
            <!--registration form end-->
            <!-- Edit form -->
            <?php 
            
            if(isset($_GET['vhedit'])) {
                $veditid = $_GET['vhedit'];
                $editstmt = "SELECT * FROM vehicle_type_master WHERE flag = 1 AND vtype_id = '$veditid'";
                $editres = $con->query($editstmt);
                $editrow = $editres->fetch_assoc();

                echo "<script>
                        document.getElementById('userRegCard').style.display = 'none';
                    </script>";

                echo "
                <div class='card reg' id='userEditCard' style='background-color: #006E38 '>
                    <form class='frm' method='POST' id='vhedit' action='../function/edit.php?vedit={$veditid}' >
                        <center><h4>Edit Vehicle Types</h4></center>
                        <div class='form-group'>
                            <label for='vhtype'>Vehicle Type</label>
                            <input type='text' class='form-control' name='vhtype' id='vhtype' value = {$editrow['vtype_name']} required>
                        </div>  
                        <div class='form-group'>
                            <label for='skey'>Shortcut Key</label>
                            <input type='text' class='form-control' name='skey' id='skey' value = {$editrow['shortcut']} required>
                        </div>    
                        
                        <br>
                            
                        <div class='form-group'>
                            <input type='submit' class='form-control' name='submit' id='submit' value='submit'>
                        </div>    
                    </form>
                </div>
                ";
            }                

            ?>
            <!-- edit form end -->
            </div>
        </div>    
    </div>
    <!--=============================-->
</body>

<script>


//script to delete vehicle types
function del(Clicked_id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this Vehicle Type!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal({title: "Vehicle Type Deleted!",
                    icon: "success",
                    button: "OK",})
            .then(() => {
            window.location.href = ("../function/delete.php?id="+Clicked_id+"&page=vehicles");
            });
            
        } else {
            swal("Vehicle type is Safe!");
        }
    });

    
}

function deactivate(vid) {
    $.ajax({
        url : '../function/inactive.php',
        type : 'GET',
        data: {"vhinactive" : vid},
        success : function(data) {
            swal ({
                title: "Deactivated",
                icon: "success",
            }).then((data) => {
                top.window.location = "./vehicles.php";
            });
        }, 
        error: function(data) {
            swal ({
                title: "Error Deactivating",
                icon : "warning",
            })
        },
    });
}

function activate(vid) {
    $.ajax({
        url : '../function/activate.php',
        type : 'GET',
        data: {"vhactive" : vid},
        success : function(data) {
            swal ({
                title: "Activated",
                icon: "success",
            }).then((data) => {
                top.window.location = "./vehicles.php";
            });
        }, 
        error: function(data) {
            swal ({
                title: "Error Activating",
                icon : "warning",
            })
        },
    });
}

var userfrm = $('#vhedit');

userfrm.submit(function(e) {

    e.preventDefault();

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
        type : "POST",
        url : userfrm.attr('action'),
        data: userfrm.serialize(),
        success: function(data) {
            swal({
            title: "Updated!",
            icon: "success",
            }).then((value) => {
                top.window.location = './vehicles.php';
            });
        },
        error : function(data) {
            alert('!!! Error Updating User Data !!!');
            console.log(data);
        }
    });

});

</script>


</html>