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
$company = $_SESSION['company'];
?>

<!DOCTYPE html>

<html>
<head>
    <title><?php echo $loginTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/custom.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/card.css">
    <link rel="stylesheet" href="css/w3.css">
    <script src="../bootstrap-4.3.1-dist/js/tether.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="../include/sweetalert.min.js"></script>
    <script src="../include/jquery-3.4.1.min.js"></script>

    <style>
    body {
        
    }
    .card {
        padding : 5vh;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 40%;    
        float : left;
        margin: 5%;
    }

    .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .container {
    padding: 2px 16px;
    }
    
    </style>
    
</head>
<!-- fetch company details -->
<?php

    // $query1 = "SELECT * FROM company_master where flag = '1' AND company_id = 'fm5d7534212edbd' ";
    // $result1 = $con->query($query1);
    // $row = $result1-> fetch_assoc();

    // $coname = $row['company_name'];
    // $coaddress = $row['company_address'];
    // $coown = $row['owner_name'];
    // $costart = $row['validity_start'];
    // $coexp = $row['validity_end'];
    // $copos = $row['postal_code'];
    // $cogps = $row['location_gps'];

?>


<!--Body of the Index page-->
<body>
    <!--============================-->
    <!---->
    <!-- column for Sidebar-->
    <?php echo $navbar;?>

    <script>
        document.getElementById("settings").classList.add('active');
    </script>
    <!--column for registration box-->
    <div class="content">
        <div class= "row">
            <div class = "col-sm-4" >
            <!--Column 1-->
            <div class="card" style="width : 90%">
                <div class="card-container" >
                    <h4 style="text-align : center"><b>GST Details</b></h4> 
                    <hr>
                    <?php 
                        $gststmt = "SELECT gst_no, cgst, sgst FROM company_master WHERE flag = 1 AND company_id = '$company'";
                        $gstres = $con->query($gststmt);
                        $gstrow = $gstres->fetch_assoc();

                        if(isset($_GET['gstedit'])) {
                            echo "
                                    <form method='POST' id = 'gstform' action = '../function/edit.php'>
                                        <div class='form-group'>
                                            <label for='gstno'>GST Number</label>
                                            <input type='text' class='form-control' name='gstno' id= 'gstno' value='{$gstrow['gst_no']}' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='cgst'>CGST Percentage</label>
                                            <input type='text' class='form-control' name='cgst' id= 'cgst' value='{$gstrow['cgst']}' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='sgst'>SGST Percentage</label>
                                            <input type='text' class='form-control' name='sgst' id= 'sgst' value = '{$gstrow['sgst']}' required>
                                        </div>
                                        <br>
                                        <div class='form-group'>
                                            <button type='submit' class='btn btn-success' name='submit' id='submit' value='submit' style='font-size : 14px; width : 100%;'>Submit</button>
                                        </div> 
                                    </form>
                            ";
                        }
                        else {
                            echo "
                                <p>GST Number : {$gstrow['gst_no']}<br>
                                CSGT : {$gstrow['cgst']}% <br>
                                SGST : {$gstrow['sgst']}% </p>
                                <center><a class='btn btn-success' href = './settings.php?gstedit=1' style='font-size : 14px; padding-left : 30px;  padding-right : 30px;'>Edit</a></center>
                            ";
                        }
                    ?>      
                           
                </div>
            </div>
            <!--Column 1 end-->   
            </div>
            <div class = "col-sm-4" >
            <!--Column 2-->
            <div class="card" style="width : 90%">
                <div class="card-container"><center>
                        Empty Card            
                </div>
            </div>
            <!--Column 2 end-->
            </div>
            <div class = "col-sm-4" >
            <!--Column 3-->
            <div class="card" style="width : 90%">
                <div class="card-container">
                    empty card                   
                </div>
            </div>
            <!--Column 3 end-->
            </div>
        </div>
    </div>
    <!--=============================-->
</body>

<script type="text/javascript">

var gstfrm = $('#gstform');

gstfrm.submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
       type: "POST",
       url: gstfrm.attr('action'),
       data: gstfrm.serialize(), // serializes the form's elements.
       success: function(data)
       {
           top.window.location = './settings.php'
       },
        error: function (data) {
            alert('!!! Edit GST Unsuccessful !!!')
            console.log('An error occurred.');
            console.log(data);
        }
     });


});

</script>


</html>