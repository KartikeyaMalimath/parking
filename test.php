<?php

require './include/escpos/autoload.php';

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

global $printerName,$printerType;

function print_ticket($ticketNo)
{
    /*#################################################################################################################################*/
    /*###################################################### Setting Printer Start ####################################################*/
    /*#################################################################################################################################*/
    global $conn;
    $fn = fopen("./config/checkin.txt","r");
    
    while(! feof($fn))  
    {
        $result = fgets($fn);
        $data=explode('|', $result, 5);
        // $userName=$_SESSION['currentUser'];
            $printerName=trim($data[1]);
            $printerType=trim($data[2]);
    }
    fclose($fn);   
    /*#################################################################################################################################*/
    /*####################################################### Setting Printer End #####################################################*/
    /*#################################################################################################################################*/
    
    $ticketDetails = $conn -> query("SELECT * FROM `transaction_table` WHERE `ticket_number`='$ticketNo'");
    if($ticketDetails->num_rows > 0)
    {
        while($ticketDetailsRow = $ticketDetails -> fetch_assoc())
        {
            $ticketNo = $ticketDetailsRow['ticket_number'];
            $vehicleNo = $ticketDetailsRow['vehicle_number'];
            $helmet_advance=$ticketDetailsRow['helmet_advn'];
            $checkin = $ticketDetailsRow['checkin_time'];
        }
    }
    
    
    try
    {
        $connector = null;
        if($printerType == 'Local')
        {
            $connector = new WindowsPrintConnector($printerName);
        }
        else if($printerType == 'Remote')
        {
            $connector = new NetworkPrintConnector($printerName, 9100);
        }
        
        $printer = new Printer($connector);
        $logo = EscposImage::load("images/logo.png", false);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> bitImage($logo);
        $printer -> setJustification(Printer::JUSTIFY_RIGHT);
        $printer -> qrCode($ticketNo);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer->text('VEHICLE TICKET MANAGEMENT'."\n");
        $printer->text('Address : Bangalore'."\n");
        $printer-> text('_______________________________________________'."\n");
        $printer -> text('Ticket No: '.$ticketNo."\n\n");
        date_default_timezone_set('Asia/Calcutta');
        date_default_timezone_set('Asia/Calcutta');
        $checkin = new DateTime(date($checkin));
        $checkTime= $checkin-> format('h:i:s a');
        $checkDate= $checkin-> format('Y/m/d');
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setTextSize(2, 1); 
        $printer -> text('  Vehicle Number: '.$vehicleNo."\n\n");
        $printer -> setTextSize(1, 1); 
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text('  Check In Date: '.$checkDate."\n\n");
        $printer -> text('  Check In Time: '.$checkTime."\n\n");
        if($helmet_advance!='')
        {
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> setTextSize(2, 1); 
            $printer -> text('  Advance Rs: '.$helmet_advance."\n\n");
            $printer -> setTextSize(1, 1); 
        }    
        
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer->barcode($ticketNo, Printer::BARCODE_CODE39);

        $printer -> cut();
        $printer -> close();
    } 
    catch(Exception $e) 
    {
        echo "printer error------------";
        echo $e->getMessage();
    }
}

?>