<?php

include ('include/db.php');

$stmt1 = "SELECT vehicle_type, count(vehicle_type) as countvhtyp FROM transaction_master GROUP BY vehicle_type ORDER BY COUNT(vehicle_type) DESC";
$res1 = $con->query($stmt1);
  
    

?>

<!DOCTYPE html>
<html lang="en-US">
<body>

<h1>My Web Page</h1>

<div id="piechart"></div>

<script type="text/javascript" src="include/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Vehicle Type', 'Total Number']
  <?php 

        while ($row1 = $res1->fetch_assoc()){
            $vtypetemp = $row1['vehicle_type'];
                $gaadi = "SELECT * FROM vehicle_type_master WHERE vtype_id = '$vtypetemp'";
                $gaadires = $con->query($gaadi);
                $gaadirow = $gaadires->fetch_assoc();
            echo ",['{$gaadirow['vtype_name']}',{$row1['countvhtyp']} ]";
        }
        ?>

//   ['Work', 8],
//   ['Eat', 2],
//   ['TV', 4],
//   ['Gym', 2],
//   ['Sleep', 8]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'My Average Day', 'width':550, 'height':400};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>

</body>
</html>


