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
            title: 'Are you sure?',
            text: 'Once deleted, you will not be able to recover this imaginary file!',
            icon: 'warning',
            buttons: ['Not paid', 'paid'],
            
          })
          .then((willDelete) => {
            if (willDelete) {
              swal('Poof! Your imaginary file has been deleted!', {
                icon: 'success',
              });
            } else {
              swal('Your imaginary file is safe!');
            }
          });
      }, 200);
    
    </script>
    ";
    if (isset($_POST['submit'])){
        echo $days." days ".$hrs." hrs ".$mins." mins";
    }

?>

