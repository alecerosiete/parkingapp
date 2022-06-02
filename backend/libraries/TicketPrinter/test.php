<?php

/* Change to the correct path if you copy this example! */
require __DIR__ . '/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */
try {
    // Enter the share name for your USB printer here
    $connector = new WindowsPrintConnector("EPSON");
    //$connector = new WindowsPrintConnector("pos");
    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);
    


    $printer->text("Hello World!\n");
    $printer->text("*************************\n");
    $printer->text("Un petit elephant\n");
    $printer->feed(2);
    $printer->text("*************************\n");
    /* Print some bold text */
    $printer->setEmphasis(true);
    $printer->text("FOO CORP Ltd.\n");
    $printer->setEmphasis(false);
    $printer->feed(2);
    $printer->text("Receipt for whatever\n");
    $printer->feed(4);

    /* Bar-code at the end */
    
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
    $printer -> barcode("9876543",Printer::BARCODE_CODE39);
    $printer -> feed(4);
     

    /*
      $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
      $printer->text("Text position\n");
      $printer->selectPrintMode();
      $hri = array(Printer::BARCODE_TEXT_NONE => "No text", Printer::BARCODE_TEXT_ABOVE => "Above", Printer::BARCODE_TEXT_BELOW => "Below", Printer::BARCODE_TEXT_ABOVE | Printer::BARCODE_TEXT_BELOW => "Both");
      foreach ($hri as $position => $caption) {
      $printer->text($caption . "\n");
      $printer->setBarcodeTextPosition($position);
      $printer->barcode("012345678901", Printer::BARCODE_JAN13);
      $printer->feed();
      }
     */


    /* Barcode types */
    /*
    $standards = array(Printer::BARCODE_UPCA => array("title" => "UPC-A", "caption" => "Fixed-length numeric product barcodes.", "example" => array(array("caption" => "12 char numeric including (wrong) check digit.", "content" => "012345678901"), array("caption" => "Send 11 chars to add check digit automatically.", "content" => "01234567890"))), Printer::BARCODE_UPCE => array("title" => "UPC-E", "caption" => "Fixed-length numeric compact product barcodes.", "example" => array(array("caption" => "6 char numeric - auto check digit & NSC", "content" => "123456"), array("caption" => "7 char numeric - auto check digit", "content" => "0123456"), array("caption" => "8 char numeric", "content" => "01234567"), array("caption" => "11 char numeric - auto check digit", "content" => "01234567890"), array("caption" => "12 char numeric including (wrong) check digit", "content" => "012345678901"))), Printer::BARCODE_JAN13 => array("title" => "JAN13/EAN13", "caption" => "Fixed-length numeric barcodes.", "example" => array(array("caption" => "12 char numeric - auto check digit", "content" => "012345678901"), array("caption" => "13 char numeric including (wrong) check digit", "content" => "0123456789012"))), Printer::BARCODE_JAN8 => array("title" => "JAN8/EAN8", "caption" => "Fixed-length numeric barcodes.", "example" => array(array("caption" => "7 char numeric - auto check digit", "content" => "0123456"), array("caption" => "8 char numeric including (wrong) check digit", "content" => "01234567"))), Printer::BARCODE_CODE39 => array("title" => "Code39", "caption" => "Variable length alphanumeric w/ some special chars.", "example" => array(array("caption" => "Text, numbers, spaces", "content" => "ABC 012"), array("caption" => "Special characters", "content" => "\$%+-./"), array("caption" => "Extra char (*) Used as start/stop", "content" => "*TEXT*"))), Printer::BARCODE_ITF => array("title" => "ITF", "caption" => "Variable length numeric w/even number of digits,\nas they are encoded in pairs.", "example" => array(array("caption" => "Numeric- even number of digits", "content" => "0123456789"))), Printer::BARCODE_CODABAR => array("title" => "Codabar", "caption" => "Varaible length numeric with some allowable\nextra characters. ABCD/abcd must be used as\nstart/stop characters (one at the start, one\nat the end) to distinguish between barcode\napplications.", "example" => array(array("caption" => "Numeric w/ A A start/stop. ", "content" => "A012345A"), array("caption" => "Extra allowable characters", "content" => "A012\$+-./:A"))), Printer::BARCODE_CODE93 => array("title" => "Code93", "caption" => "Variable length- any ASCII is available", "example" => array(array("caption" => "Text", "content" => "012abcd"))), Printer::BARCODE_CODE128 => array("title" => "Code128", "caption" => "Variable length- any ASCII is available", "example" => array(array("caption" => "Code set A uppercase & symbols", "content" => "{A" . "012ABCD"), array("caption" => "Code set B general text", "content" => "{B" . "012ABCDabcd"), array("caption" => "Code set C compact numbers\n Sending chr(21) chr(32) chr(43)", "content" => "{C" . chr(21) . chr(32) . chr(43)))));
    $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
    foreach ($standards as $type => $standard) {
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
        $printer->text($standard["title"] . "\n");
        $printer->selectPrintMode();
        $printer->text($standard["caption"] . "\n\n");
        foreach ($standard["example"] as $id => $barcode) {
            $printer->setEmphasis(true);
            $printer->text($barcode["caption"] . "\n");
            $printer->setEmphasis(false);
            $printer->text("Content: " . $barcode["content"] . "\n");
            $printer->barcode($barcode["content"], $type);
        }
    }
    $printer->feed(4);
    $printer->cut();
   */
    /* Close printer */
    $printer->close();
} catch (Exception $e) {
    print "Couldn't print to this printer: " . $e->getMessage() . "\n";
}