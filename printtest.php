<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form id='paidform' method="GET">
  <input type="text" name="paid" value="paid" hidden>
  <input type="submit" value="Submit" hidden>
</form> 
<p id='haha'></p>
</body>
</html>

<?php
echo "<script src='include\sweetalert.min.js'></script>";

date_default_timezone_set('Asia/Kolkata'); 
    $t=time();
    $time = date("d-m-Y G:i:s", $t);

    $indate = date("30-08-2019 22:30:00");
    $outdate = date("01-09-2019 21:00:00");

    $date1 = date_create($indate);
    $date2 = date_create($outdate);
    $totaldays = date_diff($date1, $date2);
    $days = $totaldays->format('%a');
    $hrs = $totaldays->format('%h');
    $mins = $totaldays->format('%i');

    echo "
    <script type='text/javascript'>
    setTimeout(function() {
        swal({
            title: 'time : ".$days."',
            text: '',
            icon: 'warning',
            buttons: ['Not paid', 'paid'],
            
          })
          .then((willDelete) => {
            if (willDelete) {
              swal({
                title: 'Good job!',
                text: 'You clicked the button!',
                icon: 'success',
                button: 'Aww yiss!',
              }).then(() => {
                window.history.pushState( {} , '', '&paid=paid' );
                window.open('index.php');
              });
              
            } else {
              window.open('index.php');
            }
          });
      }, 200);
    
    </script>
    ";
    
    //echo "<form method='post' id='myForm'><input type='submit' class='submit' id='submit'></form>";
    if (isset($_GET['paid'])){
        echo $days." days ".$hrs." hrs ".$mins." mins";
    }
?>

// top.window.location = "transaction.php?time=<?php echo $time ?>&ttldur=<?php echo $ttldurtoupdt ?>&amount=<?php echo $totalamount ?>&helcharge=<?php echo $helmetcharge ?>&cid=<?php echo $CID ?>&slabid=<?php echo $slabId ?>&slabnm=<?php echo $slabName ?>";   