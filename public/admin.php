<?php

session_start();
include ('../include/db.php');
include ('../include/data.php');
include ('adminViews/navbar.php');
if(!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    echo "<script>top.window.location = '../function/logout.php'</script>";
}
$page = "user";
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
    <script src="../include/jquery-3.4.1.min.js"></script>

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
        document.getElementById("user").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
        <div class= "row">
            <div class = "col-sm-7" >
                <table class='content-table' style="margin-top:10vh">
                    <thead>
                        <tr>
                            <th>Active users</th>
                        </tr>
                        <tr>
                        <th>User Name</th>
                        <th>Employee No.</th>
                        <th>Access Type</th>
                        <th>Deactivate</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            $query1 = "SELECT * FROM user_master where flag = '1' AND active = '1'";
                            $result1 = $con->query($query1);

                            if($result1->num_rows > 0) {
                                while($row = $result1-> fetch_assoc()) {
                                    $uid = $row['user_id'];
                                    echo   "<tr>
                                                <td>{$row['uname']}</td>
                                                <td>{$row['emp_no']}</td>
                                                <td>{$row['type']}</td>
                                                <td><button class = 'btn btn-info' style='width: 100%; color:white;' type='button' id= ".$uid." onclick='deactivate(this.id)'>Deactivate</button></td>
                                                <td><a href='./admin.php?edituser={$row['user_id']}' class = 'btn btn-success' style='width: 100%; color : white; font-size : 12px;' id= ".$uid." onclick=''>Edit</a></td>
                                                <td><button class = 'btn btn-danger' style='width: 100%;' type='button' id= ".$uid." onclick='del(this.id)'>Delete</button></td>
                                            </tr>";
                                }

                            }  
                        ?>
                    </tbody>
                </table>
                <!-- Active users end -->
                <!-- Inactive users -->
                <table class='content-table' style="margin-top:10vh">
                    <thead>
                        <tr>
                            <th>Deactivated Users</th>
                        </tr>
                        <tr>
                        <th>User Name</th>
                        <th>Employee No.</th>
                        <th>Access Type</th>
                        <th>Activate</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            $query1 = "SELECT * FROM user_master where flag = '1' AND active = '0'";
                            $result1 = $con->query($query1);

                            if($result1->num_rows > 0) {
                                while($row = $result1-> fetch_assoc()) {
                                    $uid = $row['user_id'];
                                    echo   "<tr>
                                                <td>{$row['uname']}</td>
                                                <td>{$row['emp_no']}</td>
                                                <td>{$row['type']}</td>
                                                <td><button class = 'btn btn-info' style='width: 100%;' type='button' id= ".$uid." onclick='activate(this.id)'>Activate</button></td>
                                                <td><button class = 'btn btn-danger' style='width: 100%;' type='button' id= ".$uid." onclick='del(this.id)'>Delete</button></td>
                                            </tr>";
                                }

                            }  
                        ?>
                    </tbody>
                </table>
                <!-- Inactive users end -->
            </div>
            <div class = "col-sm-5" >
            <!--Registration form-->
            <div class="card reg" id="userRegCard" >
                <form class="frm" method="POST" action="../function/register.php" >
                    <center><h4>User Registration</h4></center>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>   
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div> 
                    <div class="form-group">
                        <input type="checkbox" onClick="visible()">
                        <label for="Shpassword">Show password</label>
                    </div>    
                    <div class="form-group">
                        <label for="fullname">Fullname</label>
                        <input type="text" class="form-control" name="fullname" id="fullname" required>
                    </div> 
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" pattern="[6-9]{1}[0-9]{9}" class="form-control" name="phone" id="phone" maxlength="10" required">
                    </div>
                    <div class="form-group">
                        <label for="idtype">ID proof type</label>
                        <select class="form-control" id="idtype" name="idtype" required>
                            <option value="aadhar" selected>AADHAAR</option>
                            <option value="dl">Driving License</option>
                            <option value="votersid">Voters ID</option>
                            <option value="pan">PAN Card</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idno">ID Number</label>
                        <input type="text" class="form-control" name="idno" id="idno" required>
                    </div>
                    <div class="form-group">
                        <label for="empno">Employee Number</label>
                        <input type="text" class="form-control" name="empno" id="empno">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea rows="3" class="form-control" name="address" id="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usertype">User Type</label>
                        <select class="form-control" id="usertype" name="usertype" required>
                            <option value = "user" selected>User</option>
                            <option value = "security">Security</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <br>
                        
                    <div class="form-group">
                        <input type="submit" class="form-control" name="submit" id="submit" value="submit">
                    </div>    
                </form>
            </div>
            <!--registration form end-->

            <!-- User Edit form -->
            <?php 
                if(isset($_GET['edituser'])) {
                    $edituid = $_GET['edituser'];
                    $editstmt = "SELECT * FROM user_master WHERE flag = 1 AND user_id = '$edituid'";
                    $editres = $con->query($editstmt);
                    $editrow = $editres->fetch_assoc();

                    //Use this if password edit is required
                    // <div class='form-group'>
                    //     <label for='password'>Password</label>
                    //     <input type='password' class='form-control' name='password' id='password' required>
                    // </div> 
                    // <div class='form-group'>
                    //     <input type='checkbox' onClick='visible()'>
                    //     <label for='Shpassword'>Show password</label>
                    // </div> 

                    echo "<script>
                        document.getElementById('userRegCard').style.display = 'none';
                        </script>";
                    echo "
                    <div class='card reg' id='userEditCard' style='background-color: #006E38 '>
                        <form class='frm' id='useredit' method='POST' action='../function/edit.php?edit={$edituid}' >
                            <center><h4>Edit User</h4></center>
                            <div class='form-group'>
                                <label for='username'>Username</label>
                                <input type='text' class='form-control' value='{$editrow['uname']}' name='username' id='username' required>
                            </div>   
                               
                            <div class='form-group'>
                                <label for='fullname'>Fullname</label>
                                <input type='text' class='form-control' value='{$editrow['fullname']}' name='fullname' id='fullname' required>
                            </div> 
                            <div class='form-group'>
                                <label for='phone'>Phone Number</label>
                                <input type='tel' pattern='[6-9]{1}[0-9]{9}' value='{$editrow['phone']}' class='form-control' name='phone' id='phone' maxlength='10' required'>
                            </div>
                            <div class='form-group'>
                                <label for='idtype'>ID proof type</label>
                                <select class='form-control' id='idtype' name='idtype' required>"; 
                                    if ($editrow['id_proof_type'] == 'aadhar') {
                                        echo "<option value='aadhar' selected>AADHAAR</option>                                
                                        <option value='dl'>Driving License</option>
                                        <option value='votersid'>Voters ID</option>
                                        <option value='pan'>PAN Card</option>";
                                    } else if($editrow['id_proof_type'] == 'dl') {
                                        echo "<option value='aadhar'>AADHAAR</option>                                
                                        <option value='dl' selected>Driving License</option>
                                        <option value='votersid'>Voters ID</option>
                                        <option value='pan'>PAN Card</option>";
                                    } else if($editrow['id_proof_type'] == 'votersid') {
                                        echo "<option value='aadhar'>AADHAAR</option>                                
                                        <option value='dl'>Driving License</option>
                                        <option value='votersid' selected>Voters ID</option>
                                        <option value='pan'>PAN Card</option>";
                                    } else if($editrow['id_proof_type'] == 'pan') {
                                        echo "<option value='aadhar'>AADHAAR</option>                                
                                        <option value='dl'>Driving License</option>
                                        <option value='votersid'>Voters ID</option>
                                        <option value='pan' selected>PAN Card</option>";
                                    }
                                    
                            echo "
                                </select>
                            </div>
                            <div class='form-group'>
                                <label for='idno'>ID Number</label>
                                <input type='text' class='form-control' value='{$editrow['id_number']}' name='idno' id='idno' required>
                            </div>
                            <div class='form-group'>
                                <label for='empno'>Employee Number</label>
                                <input type='text' class='form-control' value='{$editrow['emp_no']}' name='empno' id='empno'>
                            </div>
                            <div class='form-group'>
                                <label for='address'>Address</label>
                                <textarea rows='3' class='form-control' name='address' id='address' required>{$editrow['address']}</textarea>
                            </div>
                            <div class='form-group'>
                                <label for='usertype'>User Type</label>
                                <select class='form-control' id='usertype' name='usertype' required>";
                                    if ($editrow['type'] == 'user') {
                                        echo "
                                            <option value = 'user' selected>User</option>
                                            <option value = 'security'>Security</option>
                                            <option value='admin'>Admin</option>
                                        ";
                                    } else if($editrow['type'] == 'admin') {
                                        echo "
                                            <option value = 'user'>User</option>
                                            <option value = 'security'>Security</option>
                                            <option value='admin' selected>Admin</option>
                                        ";
                                    }else if($editrow['type'] == 'security') {
                                        echo "
                                            <option value = 'user'>User</option>
                                            <option value = 'security'>Security</option>
                                            <option value='admin' selected>Admin</option>
                                        ";
                                    }
                                    
                                echo "
                                </select>
                            </div>
                            <br>
                                
                            <div class='form-group'>
                                <input type='submit' style='width : 100%; font-size: 14px;' class='btn btn-info' name='submit' id='submit' value='Update'>
                            </div>    
                        </form>
                    </div>
                    ";
                }
            ?>
            <!-- Edit form end -->
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

var userfrm = $('#useredit');

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
                top.window.location = './admin.php';
            });
        },
        error : function(data) {
            alert('!!! Error Updating User Data !!!');
            console.log(data);
        }
    });

});

function deactivate(vid) {
    $.ajax({
        url : '../function/inactive.php',
        type : 'GET',
        data: {"userinactive" : vid},
        success : function(data) {
            swal ({
                title: "Deactivated",
                icon: "success",
            }).then((data) => {
                top.window.location = "./admin.php";
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
        data: {"useractive" : vid},
        success : function(data) {
            swal ({
                title: "Activated",
                icon: "success",
            }).then((data) => {
                top.window.location = "./admin.php";
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

</script>


</html>