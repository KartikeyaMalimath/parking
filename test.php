<!DOCTYPE html>
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
    <div id="printableArea" style="width:200px;">
      <h3><center>Parking Ticktet</center></h3>
     <center><img src="dump/tranQRtemp.png" ></center>
    </div>
uyvzubgzcbgy
    <input type="button" onclick="printDiv('printableArea')" value="print a div!" />
    </body>
</html>