<?php
    session_start();
?>
<!DOCTYPE html>

<html>
<head>
    <title>Print Receipt</title>
    <script type='text/javascript'>
    
        window.print();
        
    </script>
    <style>
    p {
        margin:0px 5px 0px 5px; 
        font-size: 12px;
    }
    #info {
        padding : 8px;
    }
    td {
        font-size: 14px;
    }
    </style>
</head>
<body style='margin:0px;'>

    
        

<?php

$UID = $_SESSION['userID'];
$company = $_SESSION['company'];

include ('../include/db.php');
include('../include/phpqrcode/qrlib.php');


//echo "test";
if(isset($_POST['submit']))  
{  
    //echo "submit";
    if(empty($_POST["trnvhno"]) || empty($_POST["trsbtype"]))  
    {  
        echo '<script>alert("Both Fields are required")</script>';  
    }  
    else  
    {  
        //echo "else";
        //create time stamp
        date_default_timezone_set('Asia/Kolkata'); 
        $t=time();
        $chkintime = date("d-m-Y G:i:s", $t);

        $prdate = date("d-m-Y",$t);
        $prtime = date("G:i:s",$t);
        //Create unique User Id
        $prefix = "TKT";
        //$trnid = uniqid($prefix);

        $vhno = mysqli_real_escape_string($con, $_POST["trnvhno"]);  
        $vhtype = mysqli_real_escape_string($con, $_POST["trsbtype"]);  
        $trname = mysqli_real_escape_string($con, $_POST["trcname"]); 
        $trphone = mysqli_real_escape_string($con, $_POST["trphone"]); 
        if($_POST['trhelsel'] != 'no' ) {
            $trhel = mysqli_real_escape_string($con, $_POST["trhel"]); 
            $trhelid = $_POST['trhelsel'];
            if(!empty($_POST['trheladv'])) {
                $trheladv = mysqli_real_escape_string($con, $_POST["trheladv"]);
            }
            else {
                $trheladv = '0';
            }
        }
        else {
            $trhel = '0';
            $trheladv = '0';
        }
        //active / inactive
        $flag = 1;

        //get slab details
        $slabstmt = "SELECT * FROM slab_master WHERE vehicle_type = '$vhtype'";
        $slabres = $con->query($slabstmt);
        $slbrow = $slabres->fetch_assoc();

        //slab name and id
        $vhslabname = $slbrow['slab_name'];
        $vhslabid = $slbrow['slab_id'];
        //echo $vhslabname;
        //Inserting to database
        $trnid = "001";
        $query = "INSERT INTO transaction_master (vehicle_no, vehicle_type, customer_name, customer_phone, check_in, slab_name, slab_id, helmet_id, helmet, helmet_advance, in_username) VALUES(?,?,?,?,?,?,?,?,?,?,?)";  
        $stmt = $con->prepare($query);
        $stmt->bind_param('sssssssssss', $vhno, $vhtype, $trname, $trphone, $chkintime, $vhslabname, $vhslabid, $trhelid, $trhel, $trheladv, $UID);
        //echo "line1";

        if ($stmt->execute()) {
            //Fetch back transaction ID
            $trnid = $con->insert_id;

            //echo "line2";
            $vhstmt = "SELECT * FROM vehicle_type_master WHERE vtype_id = '$vhtype'";
            $vhres = $con->query($vhstmt);
            $vhrow = $vhres->fetch_assoc();
            //vehicle type
            $vhname = $vhrow['vtype_name'];           

            //IF successful generate QR code
            
            $tempDir = '../dump/';

            QRcode::png($trnid, $tempDir.'tranQRtemp.png', QR_ECLEVEL_L, 3);

            $comstmt = "SELECT * FROM company_master WHERE company_id = '$company' and flag = 1";
            $comres = $con->query($comstmt);
            $comrow = $comres->fetch_assoc();

            $comname = $comrow['owner_name'];

            echo "
            <script>printDiv('printmaadu');</script>
            <div id='printmaadu' style='width:235px; background-color: white;'>
            ==========================
            <center><h4 style='margin: 5px 5px 5px 5px;'>Company Name</h4></center>
            ==========================
                <div style='padding:0px;'>
                <center><img src='../dump/tranQRtemp.png' ></center>
                    <center><table style='width:95%'>
                        <tr>
                            <td>No. plate</td><td> : </td><td>".$vhno."</td> 
                        </tr>
                        <tr>
                            <td>Vehicle Type</td><td> : </td><td>".$vhname."</td>
                        </tr>
                        
                        <tr>
                            <td>Date</td><td> : </td><td>".$prdate."</td>
                        </tr>
                        <tr>
                            <td>Time</td><td> : </td><td>".$prtime."</td>
                        </tr> 
                                        
                    </table></center>
                </div>
                ==========================
                <div id='info'>
                    <p style='text-align: justify; text-justify: inter-word;'>If vehicle/Helmet is damaged/scarched, 
                    or valuables lost, we are not responsible for the loss 
                    <br>
                    If token is lost bring the original documents of the 
                    vehicle and any ID proof with a copy of xerox. and Token Number/QR Code is mandatory</p>
                </div>
                ==========================
                <center><p>---Powered By : Fusion Minds---</p></center>
                
            </div>

            <script>setTimeout(function() {top.window.location = '../public/parking.php'}, 1000);</script>
            </body>
            </html>

            ";
            //echo "<script>top.window.location = '../public/parking.php'</script>";
            exit();
        }  else {
            
        //echo "Error : " . $con->error; // on dev mode only
        echo "<script>top.window.location = '../public/parking.php'</script>";
        
        // echo "Error, please try again later"; //live environment
        }
    }

    $con->close();
}  
else {
    echo "<script>top.window.location = '../public/parking.php'</script>";
}

?>
<!-- <script>setTimeout(function() {top.window.location = '../public/parking.php'}, 5000);</script> -->
        
    