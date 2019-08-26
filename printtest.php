<!Doctype html>

<html>
<head>
    <script type="text/javascript">
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
    <form>
    <input type="text" name="test" id="test">
    <input type="submit" onClick="printDIV('print')" placeholder="submit">
    </form>
    <div class="print" id="print">
        <input type="text" id="display">
        
    </div>
    
</body>
</html>