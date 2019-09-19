<!DOCTYPE html>
<html>
    <head>
        <!-- <script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script> -->
    </head>
    <body>
    <!-- <div id="printableArea" style="width:200px; background-color:red;">
      <h3><center>Parking Ticktet</center></h3>
     <center><img src="dump/tranQRtemp.png" ></center>
    </div>
    <input type="button" onclick="printDiv('printableArea')" value="print a div!" /> -->
    <img src="images/fm5d7534212edbd.png" width="150px" height="150px">
    </body>
</html>
<?php
include ('include/db.php');

$stmt1 = "SELECT check_out, vehicle_type, count(vehicle_type) as countvhtyp FROM transaction_master WHERE check_out IS NULL GROUP BY vehicle_type ORDER BY COUNT(vehicle_type) DESC";
$res1 = $con->query($stmt1);

while ($row1 = $res1->fetch_assoc()) {
    // if($row1['check_out'] == NULL ) {
        $vtypetemp = $row1['vehicle_type'];
        $gaadi = "SELECT * FROM vehicle_type_master WHERE vtype_id = '$vtypetemp'";
        $gaadires = $con->query($gaadi);
        $gaadirow = $gaadires->fetch_assoc();
        echo ",[ '{$gaadirow['vtype_name']}', {$row1['countvhtyp']} ]";
    // }
} ?>