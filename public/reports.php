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
?>

<!DOCTYPE html>

<html>
<head>
    <title><?php echo $loginTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../include/jquery-3.4.1.min.js"></script>
    <script src="../include/jquery.min.js"></script>
    <!-- style sheets -->
    <!-- <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/custom.css"> -->
    <link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/custom.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/card.css">
    <link rel="stylesheet" href="../include/jquery.dataTables.min.css">
    <!-- bootstrap scripts -->
    
    <!-- <script src="../bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-3.3.6-dist/js/tether.min.js"></script>
    <script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <script src="../include/sweetalert.min.js"></script>
    <script src="../include/jquery.dataTables.min.js"></script>
    <script src="../include/dataTables.bootstrap.min.js"></script>
    <script src="../include/buttons.print.min.js"></script>
    <script src="../include/dataTables.buttons.min.js"></script>

<style>

.btn, .btn-info{
    font-size: 10pt;
    padding-left: 20px;
    padding-right: 20px;
    margin : 10px;
    
}

td{
    padding : 2vh;
}

</style>

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
    <div class="content" style="padding: 3vh;">
    <!-- Card for table customisation -->
    <div class="card" style="background-color:white; width: 95%">
        <div class="card-container" style="padding:2vh">
        <form>
        <table>
            <tr>
                <td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="0" checked>
                        <label class="custom-control-label" for="trans">Transaction</label>
                    </div>
                </td><td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="1" checked>
                        <label class="custom-control-label" for="trans">Vehicle Number</label>
                    </div>
                </td><td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="2" checked>
                        <label class="custom-control-label" for="trans">Vehicle Type</label>
                    </div>
                </td><td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="3" checked>
                        <label class="custom-control-label" for="trans">Check-In</label>
                    </div>
                </td><td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="4" checked>
                        <label class="custom-control-label" for="trans">Check-Out</label>
                    </div>
                </td><td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="5" checked>
                        <label class="custom-control-label" for="trans">Duration</label>
                    </div>
                </td><td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="6" checked>
                        <label class="custom-control-label" for="trans">Amount</label>
                    </div>
                </td><td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="7" checked>
                        <label class="custom-control-label" for="trans">Helmet Amount</label>
                    </div>
                </td><td>
                    <div>
                        <input type="checkbox" id="trans" style="height: 20px; width:20px" class="toggle-vis custom-control-input" data-column="8" checked>
                        <label class="custom-control-label" for="trans">GST</label>
                    </div>
                </td>
            </tr>
        </table>
        </form>
        </div>
    </div>
    <!-- card ends  -->

    <div id="test" class="table-responsive" style=" padding: 50px;background-color:white;"> 
        <table id="transaction" class="table table-striped table-bordered" style="background-color: white; margin: 5vh auto;">
            <thead>
                <tr>
                    <th data-column="0">Transaction</th>
                    <th>Vehicle Number</th>
                    <th>Vehicle Type</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Total Duration</th>
                    <th>Amount</th>
                    <th>Helmet Amount</th>
                    <th>GST</th>
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
                        //transaction id
                        $trnid = $row['trn_id'];
                        $trn = str_pad($trnid, 9, 0, STR_PAD_LEFT);
                        $trn = str_split($trn, 3);
                        $trn = implode(",", $trn);

                        $vhno = $row['vehicle_no'];
                        $vhtype = $row['vehicle_type'];
                        $trin = $row['check_in'];
                        $trout = $row['check_out'];
                        $trdur = round($row['total_duration']/60, 2 );
                        $tramt = $row['amount'];
                        
                        $trhel = $heladv + $hel;
                        $trgst = $row['gst'];

                        //fetch vehicle type
                        $query2 = "SELECT * FROM vehicle_type_master WHERE vtype_id = '$vhtype' ";
                        $result2 = $con->query($query2);
                        $row2 = $result2->fetch_assoc();

                        $vhcle = $row2['vtype_name'];

                        echo "<tr>  <td>".$trn."</td>
                                    <td>".$vhno."</td>
                                    <td>".$vhcle."</td>
                                    <td>".$trin."</td>
                                    <td>".$trout."</td>
                                    <td>".$trdur."</td>
                                    <td>".$tramt."</td>
                                    <td>".$trhel."</td>
                                    <td>".$trgst."</td></tr>";
                    }
                    
                    ?>
                
            </tbody>
            
        </table>
        
    </div>
    <!-- <button class="btn btn-info" onclick="printDiv('transaction')">Print</button> -->
    </div>
    <!--=============================-->
</body>

<script>
var table = $('#transaction').DataTable();

$(document).ready( function () {
    
 
    new $.fn.dataTable.Buttons( table, {
        buttons: [
            {
                extend: 'print',
                text: 'Print',
                className : 'btn btn-info',
                exportOptions: {
                    columns: ':visible',
                    stripHtml: false,
                    // rows: '.printabled',
                    modifier: {
                        selected: null
                    }
                }
            },
               
        ]
    } );
 
    table.buttons( 0, null ).container().prependTo(
        table.table().container()
    );

} );

$('input.toggle-vis').on( 'click', function (e) {
        // e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
// function printDiv(divName) {
//     var printContents = document.getElementById(divName).innerHTML;
//     var originalContents = document.body.innerHTML;

//     document.body.innerHTML = printContents;

//     window.print();

//     document.body.innerHTML = originalContents;
// }

</script>


</html>