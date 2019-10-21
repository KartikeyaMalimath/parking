<?php 
session_start();
// if(!isset($_SESSION['user'])){
//     echo "<script>location.href='./';</script>";
// }
// require_once('insert-data.php');
// require_once('config/set-time-zone.php');
// require_once('config/db-config.php');
// $userName=$_SESSION['currentUser'];

require './include/escpos/autoload.php';

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

global $printerName,$printerType;

function print_ticket($ticketNo)
{
    /*#################################################################################################################################*/
    /*###################################################### Setting Printer Start ####################################################*/
    /*#################################################################################################################################*/
    global $conn;
    $fn = fopen("./config/checkin.txt","r");
    
    while(! feof($fn))  
    {
        $result = fgets($fn);
        $data=explode('|', $result, 5);
        $userName=$_SESSION['currentUser'];
            $printerName=trim($data[1]);
            $printerType=trim($data[2]);
    }
    fclose($fn);   
    /*#################################################################################################################################*/
    /*####################################################### Setting Printer End #####################################################*/
    /*#################################################################################################################################*/
    
    $ticketDetails = $conn -> query("SELECT * FROM `transaction_table` WHERE `ticket_number`='$ticketNo'");
    if($ticketDetails->num_rows > 0)
    {
        while($ticketDetailsRow = $ticketDetails -> fetch_assoc())
        {
            $ticketNo = $ticketDetailsRow['ticket_number'];
            $vehicleNo = $ticketDetailsRow['vehicle_number'];
            $helmet_advance=$ticketDetailsRow['helmet_advn'];
            $checkin = $ticketDetailsRow['checkin_time'];
        }
    }
    
    
    try
    {
        $connector = null;
        if($printerType == 'Local')
        {
            $connector = new WindowsPrintConnector($printerName);
        }
        else if($printerType == 'Remote')
        {
            $connector = new NetworkPrintConnector($printerName, 9100);
        }
        
        $printer = new Printer($connector);
        $logo = EscposImage::load("images/logo.png", false);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> bitImage($logo);
        $printer -> setJustification(Printer::JUSTIFY_RIGHT);
        $printer -> qrCode($ticketNo);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer->text('VEHICLE TICKET MANAGEMENT'."\n");
        $printer->text('Address : Bangalore'."\n");
        $printer-> text('_______________________________________________'."\n");
        $printer -> text('Ticket No: '.$ticketNo."\n\n");
        date_default_timezone_set('Asia/Calcutta');
        date_default_timezone_set('Asia/Calcutta');
        $checkin = new DateTime(date($checkin));
        $checkTime= $checkin-> format('h:i:s a');
        $checkDate= $checkin-> format('Y/m/d');
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setTextSize(2, 1); 
        $printer -> text('  Vehicle Number: '.$vehicleNo."\n\n");
        $printer -> setTextSize(1, 1); 
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text('  Check In Date: '.$checkDate."\n\n");
        $printer -> text('  Check In Time: '.$checkTime."\n\n");
        if($helmet_advance!='')
        {
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> setTextSize(2, 1); 
            $printer -> text('  Advance Rs: '.$helmet_advance."\n\n");
            $printer -> setTextSize(1, 1); 
        }    
        
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer->barcode($ticketNo, Printer::BARCODE_CODE39);

        $printer -> cut();
        $printer -> close();
    } 
    catch(Exception $e) 
    {
        echo "printer error------------";
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Vehicle management</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script type='text/javascript' src='jquery.min.js'></script>
    <script type='text/javascript' src='script.js'></script>

    <script>
         $(document).ready(function(){
            $('select').on('change', function() {
                alert( this.value );
            });
        });
    </script>
</head>
<body>
<div class="container">

    <form action=""  method="POST" autocomplete="off" name="myform" onsubmit="return validateform()" >     
        <div class="row" style="margin-top:7%;">
          <div class="col-lg-3"></div>
         
          <div class="col-lg-6">
          <div class="navbar navbar-inverse" >
                <h2 class="text-center m-3 border-bottom ">Vehicle Management System</h2></div>
                <h3 class="text-right">Logged in as <b><?php  echo $_SESSION['currentUser'];?></b></h3>
                <br/>
                <a style="color:white;padding:10px;float:right;background:blue;" href="cilentviewdetails.php">Check-Out</a>
                <a style="color:white;padding:10px;float:right;background:red;margin-right:7px;" href="logout.php">Logout</a><br/><br/>
                <h3 style="margin-left:150px;">Check-In Form</h3>
                <div class="row">
                    <div class="col-lg-4 text-lg-right pt-4"><label class="">Vehicle Number :</label></div>
                    <div class="col-lg-8 pt-3">
                            <input class="form-control" type="text" id="vnumber" placeholder="Vehicle Number" name="vnumber" autofocus required>        
                    </div>
                    <div class="col-lg-4 text-lg-right pt-4"><label class="">Vehicle Type :</label></div>
                    <div class="col-lg-8 pt-3">
                    <select class="form-control" id="vtype" name="vtype" required>
                        <option value="">Select Vehicle Type</option>
                        <?php
                            $vehicleType = $conn -> query("select @a:=@a+1 serial_number, vehicle_type from (select vmt.vehicle_type from vehicle_master_table vmt, slab_master sm where vmt.vehicle_type=sm.vehicle_type and sm.vehicle_type!='helmet' GROUP by vehicle_type ORDER by vehicle_type ASC) as vt , (select @a:=0) as a");
                            if($vehicleType->num_rows > 0)
                            {
                                while($row1 = $vehicleType -> fetch_assoc())
                                {
                                ?>
                                    <option value="<?php echo $row1['vehicle_type']?>" accesskey="<?php echo $row1['serial_number']; ?>"><?php echo $row1['vehicle_type']?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    </div>
                    </div> 
                    <div class="row helmet" id="helmet">
                <!--<div class="col-lg-12 helmet" id="helmet">-->
                <div class="col-lg-4 text-lg-right pt-4"></div>
                    <div class="col-lg-8 pt-3  helmet">
                            <label class="">
                            <input  type="checkbox" id="hadvn" placeholder="Helmet" name="helmet_status" style="width:25px;height:25px" checked>&nbsp&nbsp&nbsp Helmet Status</label>
                            </div>
                            <div class="col-lg-4 text-lg-right pt-4"><label class="">No of Helmets:</label></div>
                    <div class="col-lg-8 pt-3  helmet">
                            <input class="form-control" type="number" id="helmetCount" placeholder="helmet count" name="helmetCount" value="1">        
                    </div>
                    <div class="col-lg-4 text-lg-right pt-4"><label class="">Helmet advance:</label></div>
                    <div class="col-lg-8 pt-3  helmet">
                            <input class="form-control" type="number" id="hadvn" placeholder="Helmet" name="hadvn" value="0">        
                    </div>
                    <!--</div>-->
                </div> 

                    
                    <div class="col-lg-4"></div>
                    <button type="submit" class="btn btn-primary m-4 mx-auto d-block" style="padding:10px 100px 10px 100px" id="userSubmit"  name="userSubmit">Submit</button>  
                                    
          </div>
          <div class="col-lg-3"></div> 
        </div>
        </form>    
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                    <script>
                    $(function() {
                        $("#helmet").hide();
                    $('#vtype').change(function(){
                        var val = $(this).val().toLowerCase();
                        if(val.indexOf('bike')!=-1){
                            $('#helmet').show();
                            $(hadvn).focus()
                        }else{
                            $("#helmet").hide();
                            $(userSubmit).focus()
                        }                        
                    });
                    });
                    </script>
    </body>
</html>
<?php
        if(isset($_POST['userSubmit']))
        {
            $vehicle_number=$_POST['vnumber'];
            $Vehicle_type = $_POST['vtype'];
            $loggedinUser = $_SESSION['currentUser'];

            if($Vehicle_type=='bike'){
                try{
        
                    if(empty($_POST['helmetCount'])){
                        $helmetCount=0;
                    }
                    else{
                        $helmetCount=$_POST['helmetCount'];
                    }
                    if(empty($_POST['hadvn'])){
                        $helmet_advance=0;
                    }
                    else{
                        $helmet_advance=$_POST['hadvn'];
                    }
                    if(isset($_POST['helmet_status'])){
                        $helmet_status=1;
                    }
                    else{
                        $helmet_status=0;
                    }
                }
                catch(Error  $e ){
                }
                
            }

            $taxvalue = 18;

            $tiketprefix = mysqli_query($conn,"SELECT prefix_value FROM ticket_prefix_table");
            $row = mysqli_fetch_row($tiketprefix);
            $ticpref = $row[0];
            
            $highest_id = '0';
            
            $result = mysqli_query($conn,"SELECT ticket_number FROM transaction_table where transaction_id = (SELECT MAX(transaction_id) FROM transaction_table)");
            $row = mysqli_fetch_row($result);
            $highest_id = $row[0];

            $existingPre = preg_replace('/[0-9]+/', '', $highest_id);

            echo '<script>alert('.$ticpref.'=='.$existingPre.');</script>';

            if($ticpref == $existingPre){
                echo 'same prefix';
                $highest_id = ++$highest_id;
                $ticketNo = $highest_id;
            } else {
                $highest_id = 1;
                $highest_id = $ticpref.str_pad($highest_id, 8, '0', STR_PAD_LEFT);
                $ticketNo = $highest_id;
            }

            $user_data = array(
                'vehicle_number'=>$vehicle_number,
                'ticket_number'=>$ticketNo,
                'vehicle_type' => $Vehicle_type,
                'helmet_status'=>$helmet_status,
                'helmet_count'=>$helmetCount,
                'helmet_advn'=>$helmet_advance,
                'checkin_time'=>$currentTime,
                'created_on' => $currentTime,
                'created_by' => $loggedinUser,
                'modified_on' => $currentTime,
                'modified_by' => $loggedinUser,
            );
            if(insertData('transaction_table',$user_data))
            {   
                //echo "<script>alert.window('data inserted');</script>";
               print_ticket($ticketNo);
                echo "<meta http-equiv='refresh' content='0'>";
            } 
            else 
            {
                //echo "unable to insert data";
            }
        }
?>