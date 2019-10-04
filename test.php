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
<?php
require './include/escpos/autoload.php';

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
try {
    $connector = new WindowsPrintConnector("PORTPROMPT");
    
    // A FilePrintConnector will also work, but on non-Windows systems, writes
    // to an actual file called 'LPT1' rather than giving a useful error.
    // $connector = new FilePrintConnector("LPT1");
    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);
    $printer -> text("Hello World!\n");
    $printer -> cut();
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

?>