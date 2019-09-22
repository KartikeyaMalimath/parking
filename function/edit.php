<?php 

session_start();
$user = $_SESSION['userID'];


include ('../include/db.php');

date_default_timezone_set('Asia/Kolkata'); 
$t=time();
$time = date("d-m-Y G:i:s", $t);

//Edit GST
if (isset($_POST['cgst']) && isset($_POST['gstno'])) {

    $gstno = $_POST['gstno'];
    $cgst = $_POST['cgst'];
    $sgst = $_POST['sgst'];

    $gststmt = "UPDATE company_master SET gst_no = '$gstno', cgst = '$cgst', sgst = '$sgst' WHERE flag = '1' AND company_id = 'fm5d7534212edbd'";
    mysqli_query($con, $gststmt);
    if($con->query($gststmt) == TRUE) {
        echo "Record updated successfully";
        //echo "<script>top.window.location = '../public/settings.php'</script>";
    } else {
        echo "Unsuccessful";
        //echo "<script>top.window.location = '../public/settings.php'</script>";
    }
        
}

//Edit user 
if(isset($_POST['username']) && isset($_GET['edit'])){
    $edituid = $_GET['edit'];

    $username = mysqli_real_escape_string($con, $_POST["username"]);  
    $name = mysqli_real_escape_string($con, $_POST["fullname"]); 
    $phone = mysqli_real_escape_string($con, $_POST["phone"]); 
    $idtype = mysqli_real_escape_string($con, $_POST["idtype"]); 
    $idno = mysqli_real_escape_string($con, $_POST["idno"]);
    $empno = mysqli_real_escape_string($con, $_POST["empno"]);  
    $address = mysqli_real_escape_string($con, $_POST["address"]); 
    $usertype = mysqli_real_escape_string($con, $_POST["usertype"]);

    $userstmt = "UPDATE user_master SET uname = '$username', fullname = '$name', id_proof_type = '$idtype', id_number = '$idno', emp_no = '$empno', phone = '$phone', address = '$address', type = '$usertype' WHERE user_id = '$edituid' AND flag = 1";  
    mysqli_query($con, $userstmt);

    if ($con->query($userstmt) == TRUE) {
        echo "Edit Successful";
    }  else {
        echo "Edit unsuccessful";
    }

}   

//Edit slabs
if(isset($_POST['sbname']) && isset($_GET['sbedit'])){
    $sbeditid = $_GET['sbedit'];
    $sbname = mysqli_real_escape_string($con, $_POST["sbname"]); 
    $sbtype = mysqli_real_escape_string($con, $_POST["sbtype"]); 
    $sbfrom = mysqli_real_escape_string($con, $_POST["sbfrom"]); 
    $sbto = mysqli_real_escape_string($con, $_POST["sbto"]);
    $sbcharges = mysqli_real_escape_string($con, $_POST["sbcharge"]);

    $sbstmt = "UPDATE slab_master SET slab_name = '$sbname', vehicle_type = '$sbtype', slab_from = '$sbfrom', slab_to = '$sbto', slab_charges = '$sbcharges', created_date = '$time', created_by = '$user' WHERE slab_id = '$sbeditid' ";
    mysqli_query($con, $sbstmt);
    if($con->query($sbstmt) == TRUE) {
        echo "Edit successful";
    } else {
        echo "Edit Failed";
    }

}

//Edit Vehicle Types

if(isset($_POST['vhtype']) && isset($_GET['vedit'])) {
    $veditid = $_GET['vedit'];

    $vhtype = mysqli_real_escape_string($con, $_POST["vhtype"]);
    $shkey = mysqli_real_escape_string($con, $_POST["skey"]); 

    $vstmt = "UPDATE vehicle_type_master SET vtype_name = '$vhtype', created_date = '$time', created_by = '$user', shortcut = '$shkey' WHERE vtype_id = '$veditid'";
    mysqli_query($vstmt);
    if($con->query($vstmt) == TRUE) {
        echo "Update successful";
    } else {
        echo "Update Failure";
    }

}


?>