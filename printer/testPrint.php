<?php

require __DIR__ . '/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
$connector = new Mike42\Escpos\PrintConnectors\WindowsPrintConnector("MINIPRINTER");
$printer = new Printer($connector);
$raw = rawurldecode($_GET["p"]);
$data = json_decode($raw,true);

$printer->setJustification(1);
$printer->setEmphasis(true);
$printer->feed(1);
$printer->text("*******************************\n");
$printer->text($data['company']."\n");
$printer->text("*******************************\n");
$printer->setEmphasis(false);
$printer->text("RUC: ".$data['ruc']."\n");
$printer->text("Direccion: ".$data['address']."\n");
$printer->text("Tel.: ".$data['phone']."\n");
$printer->text("CODIGO #".$data['id']."\n");
$printer->feed(1);
$printer->text("-------------------------------\n");
$printer->text("FECHA/HORA ENTRADA\n");
$printer->text("ENTRADA: ".date("d/m/Y H:i:s",strtotime($data['in']))."\n");
$printer->setBarcodeTextPosition(2);






$printer->setBarcodeWidth(4);
$printer->barcode($data['ticketId'],$printer::BARCODE_ITF);
$printer->feed(1);
$printer->text("-------------------------------\n");
$printer->feed(2);
$extravio = "No pierda su ticket, debe presentar en \ncaja para abonar el importe correspondiente, \n";
$extravio .= "en caso de extravio tiene un costo de \nGs. ".number_format($data['defaultPrice'],0,",",".")."\n";
$printer->text($extravio);
$printer->feed(2);
$printer->text("Gracias por su visita\n");
$printer->feed(2);
$printer->cut();
$printer->close();

?>
