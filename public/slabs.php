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

    <script>
        

        
    </script>
    
</head>
<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Sidebar-->
    <?php echo $navbar;?>

    <script>
        document.getElementById("slabs").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
        <div class= "row">
            <div class = "col-sm-7" >
                <table class='content-table' style="margin-top:10vh">
                    <thead>
                        <tr>
                        <th>Slab Name</th>
                        <th>Vehicle Type</th>
                        <th>Duration From</th>
                        <th>Duration To</th>
                        <th>charges</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            $query1 = "SELECT * FROM slab_master where flag = '1'";
                            $result1 = $con->query($query1);

                            if($result1->num_rows > 0) {
                                while($row = $result1-> fetch_assoc()) {
                                    $sid = $row['slab_id'];
                                    $vid = $row['vehicle_type'];
                                    $vtype = "SELECT * FROM vehicle_type_master WHERE vtype_id = '$vid'";
                                    $vtyperes = $con->query($vtype);
                                    $vtypeout = $vtyperes->fetch_assoc();
                                    echo   "<tr>
                                                <td>{$row['slab_name']}</td>
                                                <td>{$vtypeout['vtype_name']}</td>
                                                <td>{$row['slab_from']} hr</td>
                                                <td>{$row['slab_to']} hr</td>
                                                <td>{$row['slab_charges']} Rs.</td>
                                                <td><button class = 'btn btn-danger' style='width: 100%;' type='button' id= ".$sid." onclick='del(this.id)'>Delete</button></td>
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
                <form class="frm" method="POST" action="../function/slab.php" >
                    <center><h4>Slab Charges create</h4></center>
                    <div class="form-group">
                        <label for="sbname">Slab Name</label>
                        <input type="text" class="form-control" name="sbname" id="sbname" placeholder="eg: suv 1hr, bike 1-2hr" required>
                    </div>       
                    <div class="form-group">
                        <label for="sbtype">Vehicle type</label>
                        <select class="form-control" id="sbtype" name="sbtype" required>
                            <?php 

                                $query1 = "SELECT * FROM vehicle_type_master where flag = '1'";
                                $result1 = $con->query($query1);

                                if($result1->num_rows > 0) {
                                    while($row = $result1-> fetch_assoc()) {
                                        $vid = $row['vtype_id'];
                                        echo   "<option value='".$vid."'>{$row['vtype_name']}</option>";
                                    }

                                }  
                            ?>
                            <option value="helmet">Helmet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sbfrom">Slab Duration From</label>
                        <input type="text" class="form-control" name="sbfrom" id="sbfrom" placeholder="In hours" >
                    </div> 
                    <div class="form-group">
                        <label for="sbto">Slab Duration To</label>
                        <input type="text" class="form-control" name="sbto" id="sbto" placeholder="In hours" >
                    </div>
                    <div class="form-group">
                        <label for="sbcharge">Slab Charges</label>
                        <input type="text" class="form-control" name="sbcharge" id="sbcharge" placeholder="In Rupees" required>
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

<script>

//Script to delete users
function del(Clicked_id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this Slab!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            swal({title: "Slab Deleted!",
                    icon: "success",
                    button: "OK",})
            .then(() => {
            window.location.href = ("../function/delete.php?id="+Clicked_id+"&page=slabs");
            });
            
        } else {
            swal("Slab is safe!");
        }
    });
}

function duration() {
            var checkbox = document.getElementById("dur");
            if(checkbox.checked == true){
                document.getElementById("sbfrom").disabled = true;
                document.getElementById("sbto").disabled = true;
                document.getElementById("sbadd").disabled = true;
                document.getElementById("sbaddch").disabled = true;
                document.getElementById("sbfrom").placeholder = "disabled";
                document.getElementById("sbto").placeholder = "disabled"; 
                document.getElementById("sbadd").placeholder = "disabled";
                document.getElementById("sbaddch").placeholder = "disabled";
            } else {
                document.getElementById("sbfrom").disabled = false;
                document.getElementById("sbfrom").placeholder = "In hours";
                document.getElementById("sbto").disabled = false;
                document.getElementById("sbto").placeholder = "In hours";
                document.getElementById("sbadd").disabled = false;
                document.getElementById("sbadd").placeholder = "In hours";
                document.getElementById("sbaddch").disabled = false;
                document.getElementById("sbaddch").placeholder = "In Rupees";
            }
        }

</script>


</html>