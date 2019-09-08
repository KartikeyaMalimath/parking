<!DOCTYPE html>
<html>
<head>
    <title>Super Admin</title>
    <script src="../../include/jquery-3.4.1.min.js"></script>
    <script src="../../bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="../../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-4.3.1-dist/css/custom.css">
</head>
<body>
    <div class="container">
    <h2>Company Details Form</h2>
        <form class="form-horizontal" method="POST" name="coform" enctype="multipart/form-data">
            <div class="form-group">
                <label class="control-label col-sm-2" for="coname">Company Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="coname" placeholder="Company Name" name="coname" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="coadd">Company Address:</label>
                <div class="col-sm-10">
                    <textarea rows="3" class="form-control" id="coadd" placeholder="Company Address" name="coadd" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="copostal">Postal Code :</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="copostal" placeholder="Postal Code" name="copostal" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="coown">Owner Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="coown" placeholder="Company Owner" name="coown" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="costart">Validity start:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="costart" placeholder="Validity Start" name="costart" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="coexp">Validity Expire:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="coexp" placeholder="Validity Expire" name="coexp" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="cogps">GPS Location:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cogps" placeholder="GPS Location" name="cogps" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-2" for="cologo">Logo</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="cologo"/>
                </div>
            </div>

            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript">



</script>
</html>

<?php 



include ('../../include/db.php');

if(isset($_POST['submit'])){

    date_default_timezone_set('Asia/Kolkata'); 
    $t=time();
    $time = date("d-m-Y G:i:s", $t);
    //Create unique User Id
    $prefix = "fm";
    $comid = uniqid($prefix);
    //Upload Image to directory
    $image = $_FILES["cologo"]["name"];
    $uploaddir = '../../images/';
    $uploadfile = $uploaddir . $comid.".png";
    // echo '44'.$uploadfile;
    // echo "\n<p>\n";
    
    if (move_uploaded_file($_FILES['cologo']['tmp_name'], $uploadfile)) {
        //echo "File is valid, and was successfully uploaded.\n";
      //insert to database
        $coname = mysqli_real_escape_string($con, $_POST["coname"]);
        $coadd = mysqli_real_escape_string($con, $_POST["coadd"]);
        $copostal = mysqli_real_escape_string($con, $_POST["copostal"]);
        $coown = mysqli_real_escape_string($con, $_POST["coown"]);
        $costart = mysqli_real_escape_string($con, $_POST["costart"]);
        $coexp = mysqli_real_escape_string($con, $_POST["coexp"]);
        $cogps = mysqli_real_escape_string($con, $_POST["cogps"]);

        $flag = 1;
        $sadmin = "super_admin";

        $query = "INSERT INTO company_master (company_id, company_name, company_address, owner_name, validity_start, validity_end, postal_code, location_gps, created_on, created_by, flag) VALUES(?,?,?,?,?,?,?,?,?,?,?)";  
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssssssssssd',$comid, $coname, $coadd, $coown, $costart, $coexp, $copostal, $cogps, $time , $sadmin, $flag);

        if ($stmt->execute()) {
            echo "<script type='text/javascript'>alert('Company Created');</script>";
            echo "<script>top.window.location = '../../public/private/supercompany.php'</script>";
            exit();
        }  
        else {
        //echo "Error : " . $con->error; // on dev mode only
            echo "<script>top.window.location = '../../public/private/supercompany.php'</script>";
        // echo "Error, please try again later"; //livadmin.phpe environment
        }

    } else {
       echo "Upload failed";
    }
}

?>