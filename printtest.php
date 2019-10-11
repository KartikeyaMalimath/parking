<!DOCTYPE html>

<html>
<head>
    <title>Print Receipt</title>
    <script type='text/javascript'>
    
        // window.print();
        
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
<body style='margin:0px; '>
<div id='printmaadu' style='width:235px; background-color: white;'>
==========================
<center><h4 style='margin: 5px 5px 5px 5px;'>Company Name</h4></center>
==========================
    <div style='padding:0px;'>
    <center><img src='dump/tranQRtemp.png' ></center>
        <center><table style="width:95%">
            <!-- <tr>
                <td>Token No.</td><td> : </td><td>TKT5d6ba43a30ada</td> 
            </tr> -->
            <tr>
                <td>No. plate</td><td> : </td><td>1350</td> 
            </tr>
            <tr>
                <td>Vehicle Type</td><td> : </td><td>Car</td>
            </tr>
            
            <tr>
                <td>Date</td><td> : </td><td>12-12-2018</td>
            </tr>
            <tr>
                <td>Time</td><td> : </td><td>12:55:59</td>
            </tr> 
                             
        </table></center>
    </div>
    ==========================
    <div id="info">
        <p style='text-align: justify; text-justify: inter-word;'>If vehicle/Helmet is damaged/scarched, 
        or valuables lost, we are not responsible for the loss 
        <br>
        If token is lost bring the original documents of the 
        vehicle and any ID proof with a copy of xerox. and Token Number/QR Code is mandatory</p>
    </div>
    ==========================
    <center><p>---Powered By : Fusion Minds---</p></center>

</div>
</body>
</html>

<!-- <!DOCTYPE html>
<html>
    <head>
         <script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script> 
    </head>
    <body>
     <div id="printableArea" style="width:200px; background-color:red;">
      <h3><center>Parking Ticktet</center></h3>
     <center><img src="dump/tranQRtemp.png" ></center>
    </div>
    <input type="button" onclick="printDiv('printableArea')" value="print a div!" />
    <img src="images/fm5d7534212edbd.png" width="150px" height="150px">
    </body>
</html> -->